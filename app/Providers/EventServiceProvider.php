<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
        // 考试开始
        'App\Events\ExamStart' => [
            'App\Listeners\GeneratingPaper', // 生成试卷
        ],
        'App\Events\ExamEnd' => [
            'App\Listeners\CorrectionPaper', // 批改试卷
            'App\Listeners\NotExamUser', // 获取未参加考试的名单并处理
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
