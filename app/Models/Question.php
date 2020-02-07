<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
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

    protected $casts = [
        'answer' => 'array'  // answer 是一个数组
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
