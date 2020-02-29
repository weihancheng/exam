<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Paper\Import;
use App\Admin\Forms\PaperAddQuestion;
use App\Models\Paper;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

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

    // 试卷详情
    public function show($id, Content $content)
    {
        return $content->header('试卷')
            ->description('显示')
            ->body(view('admin.papers.show', ['paper' => Paper::query()->find($id)]));
    }

    // 从试卷中剔除某道题
    public function deleteQuestion(Paper $paper, Request $request)
    {
        $data = $request->only('question_id');
        $paper->questions()->detach($data['question_id']);
        // 修改试卷总数
        $paper->total = $paper->questions()->get()->count();
        $paper->save();
//        admin_toastr('删除试题成功[注:试题只是从当前试卷中剔除]');
//        return back();
    }

    // 新增题目到试卷中
    public function createQuestion(Paper $paper, Content $content)
    {
        // 使用了laravel-admin的数据表单
        $paperAddQuestion = new PaperAddQuestion();
        // 把试卷信息传递到数据表单中
        $paperAddQuestion->setPaper($paper);

        return $content->header($paper->title)
            ->description('给试卷添加新试题')
            ->body($paperAddQuestion);
    }
}
