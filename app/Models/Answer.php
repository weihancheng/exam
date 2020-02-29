<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_answer',
        'text_answer',
        'is_true',
        'type',
        'status',
        'mark'
    ];

    const ANSWER_FALSE = 0;  // 题目回答错误
    const ANSWER_TRUE = 1;  // 题目回答正确

    public static $answerMap = [
        self::ANSWER_TRUE => "正确",
        self::ANSWER_FALSE => "错误"
    ];

    const MULTIPLE_CHOICE_QUESTIONS = 'multiple';  // 多选题
    const SINGLE_CHOICE_QUESTION = 'single';  // 单选题
    const MULTIPLE_TEXT = 'multiple text'; // 填空题
    const SINGLE_TEXT = 'single text';  // 问答题

    public static $typeMap = [
        self::MULTIPLE_CHOICE_QUESTIONS => '多选题',
        self::SINGLE_CHOICE_QUESTION => '单选题',
        self::MULTIPLE_TEXT => '填空题',
        self::SINGLE_TEXT => '问答题'
    ];

    const ANSWER_STATUS_SHIP = 0;
    const ANSWER_STATUS_FINISH = 1;

    public static $statusMap = [
        self::ANSWER_STATUS_SHIP => '未批改',
        self::ANSWER_STATUS_FINISH => '已批改'
    ];

    protected $casts = [
        'is_true' => 'boolean'
    ];
}
