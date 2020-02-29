<?php

namespace App\Listeners;

use App\Events\ExamEnd;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// 处理没有参加考试的人 (考生名单中存在, 同时没有打开考试界面)
class NotExamUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 遍历没有参加考试的用户, 生成他们的考试卡
     *
     * @param  ExamEnd  $event
     * @return void
     */
    public function handle(ExamEnd $event)
    {
        $examRoom = $event->getExamRoom();
        // 获取要参加考试的名单
        $examinee = $examRoom->examinee();   // 理想考试名单
        // 获取实际参加考试的名单
        $actual_examinee = $examRoom->scores()->get()->pluck('id');
        dd($actual_examinee);
    }
}
