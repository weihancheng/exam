<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleDir;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticlesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('Id'));
        $grid->column('title', '标题');
        $grid->column('author', '上传人');
        $grid->column('sort', '文章排序');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('author', __('Author'));
        $show->field('content', __('Content'));
        $show->field('article_dir_id', __('Article dir id'));
        $show->field('sort', __('Sort'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->text('title', '标题');
        $form->text('author', '作者');
        $form->number('sort', '排序')->default(100);
        $articleDir = ArticleDir::selectOptions();
        array_shift($articleDir); // 移除数组第一个k-v
        $form->select('article_dir_id', '选择目录')->options($articleDir);
        $form->editor('content', '内容');
        return $form;
    }
}
