<?php

namespace App\Admin\Forms;

use App\Models\Item;
use App\Models\Paper;
use App\Models\Post;
use App\Models\Question;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class PaperAddQuestion extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '添加考题';
    protected $paper;

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $data = $request->only('post_id', 'question_status', 'title', 'memo', 'paper_id', 'items');

        $question = Question::create([
            'question_status' => $data['question_status'],
            'title' => $data['title'],
            'memo' => $data['memo']
        ]);
        $question->post()->associate($data['post_id']);

        $items = $data['items'];
        // 题目选项
        switch ($data['question_status']) {
            case Question::SINGLE_CHOICE_QUESTION :
                // 如果是单选时执行;
                if (collect($items)->count() < 2) {
                    admin_toastr('单选题至少有两个选项', 'error');
                    return back();
                }
                // 是答案的选项数量为1 否则报错
                $num = collect($items)->filter(function ($item) { return intval($item['is_answer']) === 1; })->count();
                if ($num !== 1) {
                    admin_toastr('单选题只允许有一个答案', 'error');
                    return back();
                }
                break;
            case Question::MULTIPLE_CHOICE_QUESTIONS :
                // 是答案的选项数量大于等于1 否则
                $num = collect($items)->filter(function ($item) { return intval($item['is_answer']) === 1; })->count();
                if ($num < 1) {
                    admin_toastr('多选题至少有一个答案', 'error');
                    return back();
                }
                break;
            default:
                break;
        }

        foreach ($items as $item) {
            Item::create([
                'content' => $item['content'],
                'memo' => $item['memo'],
                'is_answer' => $item['is_answer'],
                'question_id' => $question->id
            ]);
        }

        // 更新问题答案
        if ($data['question_status'] === Question::SINGLE_CHOICE_QUESTION
            || $data['question_status'] === Question::MULTIPLE_CHOICE_QUESTIONS) {
            $question->answer = $question->whereHas('items', function ($query) {
                $query->where('is_answer', Item::IS_ANSWER);
            })->pluck('id')->toArray();  // 问题答案
            $question->save();
        }

        // 更新时间基本信息
        $paper = Paper::query()->find($data['paper_id']);
        $paper->questions()->attach($question->id);
        $paper->total = $paper->questions()->get()->count();

        admin_success('新增题目成功.');
        return redirect(route('admin.papers.show', [$paper->id]));
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->select('post_id', '分类')->options(Post::all()->pluck('name', 'id'));
        $this->select('question_status', '题目类型')->options(Question::$typeMap);
        $this->text('title', '题目内容')->required();
        $this->text('memo', '题目解释');
        $this->hidden('paper_id', '试卷id');  // 传过来的试卷id不能写在这里, 否则会报错

        $this->hasMany('items', '选项列表', function(NestedForm $form) {
            $form->text('content', '选项内容');
            $form->text('memo', '选项解释');
            $form->number('sort', '选项顺序')->default(100);
            $form->radio('is_answer', '是否答案')->options(Item::$typeMap)->default(Item::NOT_ANSWER);
        });
    }

    // 数据默认值
    public function data()
    {
        return [
            'paper_id' => $this->paper->id,
            'question_status' => Question::SINGLE_CHOICE_QUESTION,
            'post_id' => 0
        ];
    }


    public function setPaper(Paper $paper)
    {
        $this->paper = $paper;
    }

}
