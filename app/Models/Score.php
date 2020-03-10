<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'questions_mark',
        'text_mark',
        'mark',
        'type'
    ];

    protected $appends = [
        'mark'
    ];

    // 成绩单的状态
    const SCORE_SHIP = 0;   // 成绩等待状态
    const SCORE_WAIT_CORRECTION = 1;  // 成绩等待人工批改状态 (只有有问答题&填空题的场合才需要此状态)
    const SCORE_FINISH = 3; // 批改完成状态 (自动批改和人工批改完毕后最终都会变成此状态)

    const SCORE_OVERTIME = 2;  // 用户提交的试卷超时 (比如用户考试超时了,就会标注此状态)
    const SCORE_OVERTIME_FINISH = 4; // 批改完成状态 (自动批改和人工批改完毕后最终都会变成此状态)
    const SCORE_OVERTIME_WAIT_CORRECTION = 5;  // 待批改同时标注当前考试考试超时

    const SCORE_NOT_EXAM = 6;   // 不需要批改直接得到成绩

    // 试卷类型
    public static $scoreType =[
        self::SCORE_SHIP => '待批改',
        self::SCORE_WAIT_CORRECTION => '待人工批改',
        self::SCORE_FINISH => '批改完毕',

        self::SCORE_OVERTIME => '用户提交的试卷超时',
        self::SCORE_OVERTIME_WAIT_CORRECTION => '超时用户待人工批改',
        self::SCORE_OVERTIME_FINISH => '超时试卷批改完毕',
        self::SCORE_NOT_EXAM => '考生没有参加考试'
    ];

    // 关联成绩表
    public function examRoom()
    {
        return $this->belongsTo(ExamRoom::class);
    }


    // 关联成绩表
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 考试重得分
    public function getMarkAttribute()
    {
        return intval($this->questions_mark) + intval($this->text_mark);
    }
}
