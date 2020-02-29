<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\ExamRoom;
use App\Models\Paper;
use App\Models\Question;
use App\Models\Score;
use App\Models\Option;
use Illuminate\Support\Carbon;

class AnswersController extends Controller
{
    // 用户提交试卷
    public function store(AnswerRequest $request)
    {
        // 判断当前提交试卷的用户,是否属于本考场的考生
        $exam_room_id = $request->input('exam_room_id');
        $examRoom = ExamRoom::find($request->input('exam_room_id'));
        if (!in_array($request->user()->id, $examRoom->examinee()->get()->pluck('id')->toArray()))
            throw new InvalidRequestException('你不属于本次考试');

        // 防止用户重复点击, 方法查找score查看是否有响应的答题卡
        if (Score::query()->where('user_id', $request->user()->id)->where('exam_room_id', $examRoom->id)->exists())
            throw new InvalidRequestException('你已提交试卷');

        // 创建用户试卷评分卡
        $score = new Score([
            'type' => Score::SCORE_SHIP
        ]);

        // 判断是否超出了考试结束时间&判断是否早于考试开始时间
        $test_timout_delay_time = Carbon::now()->timestamp + intval(Option::get('test_timeout_delay_time'));
        if ($test_timout_delay_time > $examRoom->end_at) {
            $score->type == Score::SCORE_OVERTIME;    // 标记当前用户考试超时
            $examRoom->stuatus == ExamRoom::EXAM_ROOM_STATUS_END;  //考试结束
            $examRoom->save();
        }

        $score->user_id = $request->user()->id;
        $score->exam_room_id = $exam_room_id;
        $score->save();

        // 对传过来的答题卡进行格式化
        $answers = $this->answerFormat($request->input('answers'));

        // 题目批改
        $this->correction($answers, $score, $request->user(), $examRoom);
    }

    // 将用户提交的答案进行整理
    public function answerFormat($answers)
    {
        // 当用户提交的答题卡题目总数量有异常时,会触发问题id去重复
        $ids = array_unique(array_column($answers, 'id'));
        if (count($ids) != count($answers)) {
            $format_answers = [];  // 暂存处理过的数据
            foreach ($ids as $id) {
                foreach ($answers as $answer) {
                    if (intval($id) === intval($answer['id'])) {
                        $format_answers[] = $answer;
                        break;
                    }
                }
            }
            $answers = $format_answers;
        }
        return $answers;
    }

    // 批改试卷 同时存入数据库
    public function correction($answers, $score, $user, $examRoom)
    {
        // 加载每种题目的分值
        $multiple_mark = Option::get('multiple_choice_question_mark');
        $single_mark = Option::get('single_choice_question_mark');

        // 计算选择题总分
        $questions_mark = 0;
        // 将用户答题卷保存到数据库
        foreach ($answers as $answer) {
            $question = Question::find($answer['id']);
            // 如果当前题目为单选题
            if ($question->question_status === Question::SINGLE_CHOICE_QUESTION) {
                $mark = intval($answer['value']) === intval($question->answer[0]) ? $single_mark : 0;
                $answer_obj = new Answer([
                    'question_answer' => $answer['value'],
                    'mark' => $mark,
                    'is_true' => intval($answer['value']) === intval($question->answer[0]) ? Answer::ANSWER_TRUE : Answer::ANSWER_FALSE,
                    'type' => Question::SINGLE_CHOICE_QUESTION,
                    'status' => Answer::ANSWER_STATUS_FINISH
                ]);
                $questions_mark += $mark;
            }

            // 如果当前题目为多选题
            if ($question->question_status === Question::MULTIPLE_CHOICE_QUESTIONS) {
                $answer['value'] = array_unique($answer['value']);
                $bool = true;
                if (count($answer) == count($question->answer)) {
                    foreach ($question->answer as $true_answer) {
                        if (!in_array($true_answer, $answer['value'])) {
                            $bool = false;
                        }
                    }
                } else {
                    $bool = false;
                }

                $answer_obj = new Answer([
                    'question_answer' => is_array($answer['value']) ? implode(',', $answer['value']) : $answer['value'],
                    'mark' => $bool ? $multiple_mark : 0,  // 多选题分值
                    'is_true' => $bool ? Answer::ANSWER_TRUE : Answer::ANSWER_FALSE,
                    'type' => Question::MULTIPLE_CHOICE_QUESTIONS,
                    'status' => Answer::ANSWER_STATUS_FINISH
                ]);
                $questions_mark += $bool ? $multiple_mark : 0;
            }

            // 如果是问答题
            if ($question->question_status === Question::SINGLE_TEXT) {
                $answer_obj = new Answer([
                    'text_answer' => $answer['value'],
                    'status' => Answer::ANSWER_STATUS_SHIP,
                    'type' => Question::SINGLE_TEXT
                ]);
            }

            // 如果是填空题
            if ($question->question_status === Question::MULTIPLE_TEXT) {
                $answer_obj = new Answer([
                    'text_answer' => json_encode($answer['value']),
                    'status' => Answer::ANSWER_STATUS_SHIP,
                    'type' => Question::MULTIPLE_TEXT
                ]);
            }

            // 关联用户信息&考场信息
            $answer_obj->user_id = $user->id;
            $answer_obj->exam_room_id = $examRoom->id;
            $answer_obj->paper_id = $examRoom->paper()->first()->id;
            $answer_obj->question_id = $question->id;
            $answer_obj->save();
        }

        // 如果是正常提交用户
        if ($examRoom->paper()->first()->question_status === Paper::PAPER_ONLY_QUESTION && $score->type === Score::SCORE_SHIP) { // 如果本试卷只有选择题
            $score->questions_mark = $questions_mark; //选择题总分
            $score->type = Score::SCORE_FINISH;  // 批改完毕
        } else { // 如果本试卷有问答题或者填空题
            $score->questions_mark = $questions_mark;
            $score->type = Score::SCORE_WAIT_CORRECTION;  // 等待人工批改
        }

        // 超时用户提交
        if ($examRoom->paper()->first()->question_status === Paper::PAPER_ONLY_QUESTION && $score->type === Score::SCORE_OVERTIME) { // 如果本试卷只有选择题
            $score->questions_mark = $questions_mark; //选择题总分
            $score->type = Score::SCORE_OVERTIME_FINISH;  // 批改完毕
        } else { // 如果本试卷有问答题或者填空题
            $score->questions_mark = $questions_mark;
            $score->type = Score::SCORE_OVERTIME_WAIT_CORRECTION;  // 等待人工批改
        }
        $score->save();
    }
}
