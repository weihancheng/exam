<?php

namespace App\Models;

use App\Events\ExamEnd;
use App\Events\ExamStart;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExamRoom extends Model
{
    protected $fillable = [
        'name',
        'top',
        'start_at',
        'end_at',
        'top',
        'students'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'students' => 'array'
    ];

    protected $appends = [
        'exam_second',
        'exam_minute'
    ];

    // 试卷类型
    const EXAM_ROOM_STATUS_SHIP = 0;  //准备阶段
    const EXAM_ROOM_STATUS_NOW = 1;  // 正在考试
    const EXAM_ROOM_STATUS_END = 2;  // 考试结束

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
        self::EXAM_ROOM_STATUS_SHIP => '准备考试',
        self::EXAM_ROOM_STATUS_NOW => '正在考试',
        self::EXAM_ROOM_STATUS_END => '考试结束',
    ];

    // 模型关联
    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    // 模型关联批改者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 模型关联考生 这里不用students的原因是exam_rooms表已经定义了students字段(防止报错)
    public function examinee()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // 关联成绩表
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * 返回考试总秒数
     * @return integer
     */
    public function getExamSecondAttribute()
    {
        // 考试总共时间的时间戳
        return $this->end_at->timestamp - $this->start_at->timestamp;
    }

    /**
     * 返回考试需要多少分钟
     * @return string
     */
    public function getExamMinuteAttribute()
    {
        return (intval($this->end_at->timestamp) - intval($this->start_at->timestamp)) / 60 . '分钟';
    }

    /**
     * 返回考试需要多少分钟
     * @return string
     */

    public function getBackgroundColorAttribute()
    {
        $colorStr = "";
        for ($i = 0; $i < mb_strlen($this->name); $i ++) {
            $colorStr .= bin2hex($this->name[$i])[1];
        }
        if (strlen($colorStr) > 6) $colorStr = substr($colorStr, 0, 6);
        if (strlen($colorStr) < 4) $colorStr = substr(str_repeat($colorStr, 3), 0, 6);
        return "#" . $colorStr;
    }

    /**
     * 考场功能核心函数
     * 更新考场状态
     */
    public static function updateStatus()
    {
        // 获取所有[正在考试, 待考]考场
        $collections = self::query()->whereIn('status', [self::EXAM_ROOM_STATUS_NOW, self::EXAM_ROOM_STATUS_SHIP])->get();

        foreach ($collections as $collection) {
            $start_at = $collection->start_at;
            $end_at = $collection->end_at;
            // 如果当前时间大于考试开始时间和考试结束时间, 把状态设置成考试结束
            if (Carbon::now()->gt($start_at) && Carbon::now()->gt($end_at)) {
                $collection->status = self::EXAM_ROOM_STATUS_END;
                $collection->save();
                // 触发考试结束
                self::examEnd($collection);
                continue;
            }
            // 运行这里的可能性不高
            if ($collection->status == self::EXAM_ROOM_STATUS_NOW) {
                if (Carbon::now()->gt($end_at)) {
                    $collection->status = self::EXAM_ROOM_STATUS_END;
                    $collection->save();
                    // 触发考试结束
                    self::examEnd($collection);
                    continue;
                }
            }
            // 当前状态为待考试
            if ($collection->status == self::EXAM_ROOM_STATUS_SHIP) {
                // 如果当前当前时间大于考试开始时间且小于考试结束时间, 转为开始考试
                if (Carbon::now()->gt($start_at) && Carbon::now()->lt($end_at)) {
                    $collection->status = self::EXAM_ROOM_STATUS_NOW;
                    $collection->save();
                    // 触发考试开始事件
                    self::examStart($collection);
                    // 考试开始: 1.生成试卷缓存
                }
            }
        }
    }

    // 考试开始
    public static function examStart($examRoom)
    {
        event(new ExamStart($examRoom));
    }

    public static function examEnd($examRoom)
    {
        event(new ExamEnd($examRoom));
    }
}
