<?php

namespace App\Listeners;

use App\Events\ExamStart;
use Illuminate\Support\Facades\Cache;

// 考试开始时, 生成试卷缓存
class GeneratingPaper
{
    /**
     * Handle the event.
     *
     * @param  ExamStart  $event
     * @return void
     */
    public function handle(ExamStart $event)
    {
        // 获取考场信息
        $examRoom = $event->getExamRoom();
        $paperData = $examRoom->paper()->with('questions.items')->get();  //获取试卷完整数据
        Cache::tags('paper')->put($paperData->id, $paperData->toArray(), config('cache.paper_cache_time'));
    }
}
