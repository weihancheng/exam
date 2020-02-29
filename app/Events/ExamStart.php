<?php

namespace App\Events;

use App\Models\ExamRoom;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// 考试开始事件
class ExamStart
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $examRoom;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ExamRoom $examRoom)
    {
        $this->examRoom = $examRoom;
    }

    /**
     * 获取考场信息
     * @return ExamRoom
     */
    public function getExamRoom()
    {
        return $this->examRoom;
    }

}
