<?php

namespace App\Http\Requests;

use App\Models\ExamRoom;
use App\Models\Question;
use Illuminate\Validation\Rule;

class AnswerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 获取试卷题目列表
        $questions = ExamRoom::find($this->input('exam_room_id'))
            ->paper()
            ->with('questions')
            ->get()
            ->pluck('questions')
            ->toArray()[0];
        $menu = array_column($questions, 'id');  // 本次考试的题目id列表
        return [
            'exam_room_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!ExamRoom::find($value)) return $fail('提交上来的考场id不存在');
                }
            ],
            'answers.*.id'=> [
                'required',
                function ($attribute, $value, $fail) use($menu) {  // 对用户提交的问题id进行检测
                    if (!$question = Question::find($value)) return $fail('该题目不存在');  // 查看用户提交的id数据库是否存在
                    if (!in_array($question->id, $menu)) return $fail($question->id . '不属于本次考试内容');  // 查看用户提交的id是否属于本次考试
                }
            ]
        ];
    }
}
