<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $fillable = [
        'author',
        'total',
        'content',
        'description',
        'title',
        'type'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    // 试卷类型
    const PAPER_ONLY_QUESTION = 0;
    const PAPER_QUESTION_AND_TEXT = 1;

    // 试卷类型
    public static $paperType =[
        self::PAPER_ONLY_QUESTION => '只有选择题',
        self::PAPER_QUESTION_AND_TEXT => '选择题和文本题',
    ];

    // 模型关联
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
