<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRoom extends Model
{
    protected $fillable = [
        'name',
        'top',
        'start_at',
        'end_at',
        'top'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    // 试卷类型
    const EXAM_ROOM_STATUS_SHIP = 0;  //准备阶段
    const EXAM_ROOM_STATUS_START = 1; //考试开始
    const EXAM_ROOM_STATUS_NOW = 2;  // 正在考试
    const EXAM_ROOM_STATUS_END = 3;  // 考试结束

    // 是否置顶
    const NOT_TOP = 0;  // 不置顶
    const IS_TOP = 1;  // 置顶

    // 置顶
    public static $topType = [
        self::IS_TOP => "置顶",
        self::NOT_TOP => "不置顶"
    ];

    // 试卷类型
    public static $examRoomType =[
        self::EXAM_ROOM_STATUS_SHIP => '考试准备阶段',
        self::EXAM_ROOM_STATUS_START => '考试开始',
        self::EXAM_ROOM_STATUS_NOW => '正在考试',
        self::EXAM_ROOM_STATUS_END => '考试结束',
    ];

    // 模型关联
    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
