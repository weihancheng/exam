<?php

namespace App\Admin\Controllers;

use App\Models\Option;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OptionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Option());

        $grid->column('id', 'Id');
        $grid->column('key', '键名');
        $grid->column('value', '内容');
        $grid->column('name', '中文名称');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');
        $grid->actions(function ($actions) {
            // 去掉编辑
            $actions->disableEdit();
        });
        // 去掉批量操作
        $grid->disableBatchActions();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Option());

        $form->text('key', __('键名'));
        $form->text('value', __('内容'));
        $form->text('name', __('中文名称'));

        return $form;
    }
}
