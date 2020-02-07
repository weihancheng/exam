<?php

namespace App\Admin\Controllers;

use App\Models\Item;
use App\Models\Post;
use App\Models\Question;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QuestionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '题目';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

        $grid->column('id', 'Id');
        $grid->column('post.name', '分类')->display(function ($value) {
            return $value ?: '未分类';
        });
        $grid->column('question_status', '题目类型')->display(function ($value) {
            return Question::$typeMap[$value];
        });
        $grid->column('title', '题目内容');
        $grid->column('memo',  '题目解释')->hide();
        $grid->column('created_at', '创建时间');

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Question());

        $postMap = Post::all()->pluck('name', 'id');
        $form->select('post_id', '分类')->options($postMap)->default(0);
        $form->select('question_status', '题目类型')->options(Question::$typeMap)->default(Question::SINGLE_CHOICE_QUESTION);
        $form->text('title', '题目内容');
        $form->text('memo', '题目解释');
        $form->hasMany('items', '选项列表', function(Form\NestedForm $form) {
            $form->text('content', '选项内容');
            $form->text('memo', '选项解释');
            $form->number('sort', '选项顺序')->default(100);
            $form->radio('is_answer', '是否答案')->options(Item::$typeMap)->default(Item::NOT_ANSWER);
        });

        $form->saving(function (Form $form) {
            $items = $form->input('items');
            // 题目选项
            switch ($form->input('question_status')) {
                case Question::SINGLE_CHOICE_QUESTION :
                    // 如果是单选时执行;
                    if (collect($items)->count() < 2) {
                        admin_toastr('单选题至少有两个选项', 'error');
                        return back();
                    }
                    // 是答案的选项数量为1 否则报错
                    $num = collect($items)->filter(function ($item) {;
                        return intval($item['is_answer']) === 1;
                    })->count();
                    if ($num !== 1) {
                        admin_toastr('单选题只允许有一个答案', 'error');
                        return back();
                    }
                    break;
                case Question::MULTIPLE_CHOICE_QUESTIONS :
                    // 是答案的选项数量大于等于1 否则
                    $num = collect($items)->filter(function ($item) {;
                        return intval($item['is_answer']) === 1;
                    })->count();
                    if ($num < 1) {
                        admin_toastr('多选题至少有一个答案', 'error');
                        return back();
                    }
                    break;
                default:
                    break;
            }
        });

        // 更新问题答案
        $form->saved(function (Form $form) {
            if ($form->model()->question_status === Question::SINGLE_CHOICE_QUESTION
                || $form->model()->question_status === Question::MULTIPLE_CHOICE_QUESTIONS) {
                $form->model()->answer = $form->model()->whereHas('items', function ($query) {
                    $query->where('is_answer', Item::IS_ANSWER);
                })->pluck('id')->toArray();  // 问题答案
                $form->model()->save();
            }
        });

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Question::query()->with(['post', 'items' => function ($query) {
            $query->orderBy('sort');
        }])->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', '问题');
        $show->field('memo', '问题解释');
        $show->items('选项列表', function ($items) {
            $items->id('Id');
            $items->sort('选项排序');
            $items->content('选项内容');
            $items->memo('选项解释')->display(function ($value) {
                return $value ?: "暂无解释";
            });
            $items->disableActions();
            $items->disablePagination();
            $items->disableCreateButton();
            $items->disableExport();
            $items->disableRowSelector();
            $items->disableFilter();

        });
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }
}
