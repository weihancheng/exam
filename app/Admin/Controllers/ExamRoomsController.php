<?php

namespace App\Admin\Controllers;

use App\Models\ExamRoom;
use App\Models\Paper;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Carbon;
use Illuminate\Support\MessageBag;

class ExamRoomsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '考场';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ExamRoom());
        $grid->model()->orderBy('created_at', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('paper_id', '试卷名')->display(function ($value) {
            $paper = Paper::find($value);
            return $paper->title;
        });
        $grid->column('name', '考场名称');

        $grid->column('exam_minute', '考试总时间');
        $grid->column('top', '是否置顶')->display(function ($value) {
            return ExamRoom::$topType[$value];
        });
        $grid->column('status', '考场状态')->display(function ($value) {
            return ExamRoom::$examRoomType[$value];
        });
        $grid->column('user_id', '考场创建人')->display(function ($value) {
            $user = User::find($value);
            return $user->username;
        });

        $grid->column('start_at', '考试开始时间');
        $grid->column('end_at', '考试结束时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ExamRoom::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('paper_id', '试卷名')->as(function ($paper_id) {
            return Paper::where('id', $paper_id)->first()->title;
        });
        $show->field('name', '考场名称');
        $show->field('top', '是否置顶')->using(ExamRoom::$topType);
        $show->field('status', '考场状态')->using(ExamRoom::$examRoomType);
        $show->field('user_id', '考场批改人')->as(function ($user_id) {
            return User::query()->where('id', $user_id)->first()->username;
        });
        $show->field('students', '考生名单')->as(function ($students) {
            $users = User::query()->whereIn('id', $students)->get()->pluck('username')->toArray();
            return implode(' , ', $users);
        });

        $show->field('start_at', '考试开始时间');
        $show->field('end_at', '考试结束时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        $form = new Form(new ExamRoom());

        $form->select('paper_id', '选择试卷')
            ->options(Paper::all()->pluck('title', 'id'))
            ->required()
            ->rules('required');

        $form->multipleSelect('students', '考生名单')
            ->options(User::all()->pluck('username', 'id'))
            ->required()
            ->rules('required');

        $form->text('name', '考场名称')->required()->rules('required');
        $form->radio('top', '是否置顶')->options(ExamRoom::$topType)->default(ExamRoom::NOT_TOP);
        $form->select('user_id', '试卷批改人')
            ->options(User::all()->pluck('username', 'id'))
            ->rules('required')
            ->required();
        $form->datetime('start_at', '考试开始时间')
            ->default(date('Y-m-d H:i:s'))
            ->required()
            ->rules('required');
        $form->datetime('end_at', '考试结束时间')
            ->default(date('Y-m-d H:i:s'))
            ->required()
            ->rules('required');

        $form->saving(function (Form $form) {
            // 校验考试时间: 判断考试结束时间是否大于开始时间
            if (!Carbon::parse($form->end_at)->gt($form->start_at)) {
                $error = new MessageBag([
                    'title'   => '参数异常',
                    'message' => '考试结束时间必须大于考试开始时间',
                ]);
                return back()->with(compact('error'));
            }

            // 考生名单处理
            $students = $form->students;
            array_pop($students);
            $students = array_map(function ($item) {
                return intval($item);
            }, $students);
            $form->students = $students;
        });

        $form->saved(function (Form $form) {
            $form->model()->examinee()->sync($form->model()->students);
        });

        // 刷新考场状态
        ExamRoom::updateStatus();

        return $form;
    }

    // 考场生成,考生名单通过excel进行上传
    public function excelForm()
    {
        $form = new Form(new ExamRoom());

        $form->select('paper_id', '选择试卷')
            ->options(Paper::all()->pluck('title', 'id'))
            ->required()
            ->rules('required');

        $form->file('students', '考生名单上传[方式二]')
            ->rules('mimes:xls,xlsx')
            ->help('注: excel上传, 选择框上传和excel上传选择其中一种方式上传即可')
            ->required();

        $form->text('name', '考场名称')->required();
        $form->radio('top', '是否置顶')->options(ExamRoom::$topType)->default(ExamRoom::NOT_TOP);
        $form->select('user_id', '试卷批改人')
            ->options(User::all()->pluck('username', 'id'))
            ->rules('required')
            ->required();
        $form->datetime('start_at', '考试开始时间')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_at', '考试结束时间')->default(date('Y-m-d H:i:s'));

        $form->saving(function (Form $form) {
            // 通过多项选择框选择考试名单
            $students = $form->students;
            array_pop($students);
            $form->students = $students;
        });

        return $form;
    }
}
