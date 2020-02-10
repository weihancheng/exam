<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Paper\Import;
use App\Models\Paper;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PapersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '试卷';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Paper());

        $grid->column('id', 'Id');
        $grid->column('author', '作者');
        $grid->column('total', '数量');
        $grid->column('description', '详情')->hide();
        $grid->column('title', '标题');
        $grid->column('type', '试卷类型')->using(Paper::$paperType);
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间')->hide();

        $grid->tools(function ($tools) {
            $tools->append(new Import());
        });

        $grid->disableCreateButton();

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
        $show = new Show(Paper::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('author', '作者');
        $show->field('total', '题目数量');
        $show->field('description', '详情');
        $show->field('title', '标题');
        $show->field('type', '类型')->using(Paper::$paperType);
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Paper());
        // 试卷基本信息 添加, 编辑
        $form->setTitle('试卷基本信息');
        $form->text('author', '作者');
        $form->text('description', '详情');
        $form->text('title', '标题');

        return $form;
    }

}
