<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const NOT_ANSWER = 0;  // 不是答案
    const IS_ANSWER = 1;  // 是答案

    public static $typeMap = [
        self::IS_ANSWER => "是",
        self::NOT_ANSWER => "否"
    ];

    protected $fillable = ['content', 'sort', 'is_answer', 'memo', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
