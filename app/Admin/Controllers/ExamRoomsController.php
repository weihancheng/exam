<?php

namespace App\Admin\Controllers;

use App\Models\ExamRoom;
use App\Models\Paper;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('Id'));
        $grid->column('paper_id', '试卷名');
        $grid->column('name', '考场名称');
        $grid->column('top', '是否置顶');
        $grid->column('status', '考场状态');
        $grid->column('user_id', '考场创建人');
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
        $show->field('paper_id', '试卷名');
        $show->field('name', '考场名称');
        $show->field('top', '是否置顶')->using(ExamRoom::$topType);
        $show->field('status', '考场状态')->using(ExamRoom::$examRoomType);
        $show->field('user_id', '考场创建人');
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

        $form->select('paper_id', '试卷名称')
            ->options(Paper::all()->pluck('title', 'id'))
            ->required()
            ->rules('required');
        $form->text('name', '姓名');
        $form->radio('top', '是否置顶')->options(ExamRoom::$topType)->default(ExamRoom::NOT_TOP);
        $form->select('user_id', '考场管理员')
            ->options(User::all()->pluck('username', 'id'))
            ->required()
            ->rules('required');
        $form->datetime('start_at', '考试开始时间')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_at', '考试结束时间')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
