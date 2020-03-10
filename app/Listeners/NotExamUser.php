<?php

namespace App\Listeners;

use App\Events\ExamEnd;
use App\Models\Score;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// 处理没有参加考试的人 (考生名单中存在, 同时没有打开考试界面)
class NotExamUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 遍历没有参加考试的用户, 生成对应的Score
     *
     * @param ExamEnd $event
     * @return void
     */
    public function handle(ExamEnd $event)
    {
        $examRoom = $event->getExamRoom();
        // 获取没有参加考试的考生
        $not_examinees = array_diff($examRoom->examinee()->get()->pluck('id')->toArray(),
            array_unique($examRoom->scores()->get()->pluck('user_id')->toArray()));
        foreach ($not_examinees as $examinee) {
            $score = new Score([
                'questions_mark' => 0,  // 选择题总分
                'text_mark' => 0,  // 问答题总分
                'type' => Score::SCORE_NOT_EXAM,   // 标记考试没有参加考试
            ]);
            $score->user_id = $examinee;  // 用户id
            $score->exam_room_id = $examRoom->first()->id; // 考场id
            $score->save();
        }
    }
}
