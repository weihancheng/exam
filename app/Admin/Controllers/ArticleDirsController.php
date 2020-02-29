<?php

namespace App\Admin\Controllers;

use App\Models\ArticleDir;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class ArticleDirsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文档目录标题';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $content = ArticleDir::tree(function (Tree $tree) {
            $tree->branch(function ($data) {
                return "{$data['id']} - {$data['category']}";
            });
        });
        return $content;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ArticleDir());

        $form->display('id', 'Id');
        $form->text('category', '目录名称[文档名称]');
        $form->number('sort', '排序')->default(100);
        $form->select('pid', '所属类别')->options(ArticleDir::selectOptions());
        $form->text('memo', '备注');
        $form->select('user_id', '作者名称')->options(User::all()->pluck('username', 'id'));

        return $form;
    }
}
