<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Score\Correction;
use App\Models\Answer;
use App\Models\ExamRoom;
use App\Models\Paper;
use App\Models\Score;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoresController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '成绩列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Score());

        $grid->column('id', __('Id'));
        $grid->column('exam_room_id', '考场名称')->display(function ($value) {
            return ExamRoom::find($value)->name;
        });
        $grid->column('type', '成绩状态')->display(function ($value) {
            return Score::$scoreType[$value];
        });
        $grid->column('user_id', '考生名称')->display(function ($value) {
            return User::find($value)->username;
        });
        $grid->column('questions_mark', '选择题得分');
        $grid->column('text_mark', '填空题&问答题');
        $grid->column('mark', '考试总成绩')->display(function ($value) {
            if ($this->type === Score::SCORE_FINISH
                || $this->type === Score::SCORE_OVERTIME_FINISH
                || $this->type === Score::SCORE_NOT_EXAM)
                return $value;
            return '等待批改';
        });
        $grid->column('updated_at', '更新时间');

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            $actions->add(new Correction());
        });

        $grid->batchActions(function ($batch) {
            // 禁止批量删除
            $batch->disableDelete();
        });

        // 禁止创建
        $grid->disableCreateButton();
        // 禁止创建
        $grid->disableExport();

        // 定义过滤器
        $grid->filter(function($filter){

        });

        return $grid;
    }

    /**
     * 批改界面
     */
    public function correction(Score $score, Content $content)
    {
        // 获取用户回答
        return $content->header('试卷')
            ->description('批改')
            ->body(view('admin.scores.corretion', [
                'paper' => Paper::query()->with(['questions', 'questions.answers' => function ($query) use ($score) {
                    $query->where('user_id', $score->user_id)->where('exam_room_id', $score->exam_room_id);
                }])->find($score->examRoom()->first()->paper_id),
                'score' => $score
            ]));
    }

    /**
     * @param $correction 更新或添加批改数据
     */
    public function correctionUpdate(Score $score, Request $request)
    {
        $correction = $request->input('correction');

        DB::transaction(function () use($score, $correction) {
            $text_mark = 0;
            foreach ($correction as $item) {
                $text_mark += $item['value'];
                $answer = Answer::query()
                    ->where('question_id', $item['question_id'])
                    ->where('user_id', $score->user_id)
                    ->where('exam_room_id', $score->exam_room_id)
                    ->first();
                $answer->mark = $item['value'];
                $answer->save();
            }
            if ($score->type = Score::SCORE_OVERTIME_WAIT_CORRECTION) $score->type = Score::SCORE_OVERTIME_FINISH;
            if ($score->type = Score::SCORE_WAIT_CORRECTION) $score->type = Score::SCORE_FINISH;
            $score->text_mark = $text_mark;
            $score->save();
        });
    }
}
