<?php

namespace App\Listeners;

use App\Events\ExamEnd;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CorrectionPaper implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  ExamEnd  $event
     * @return void
     */
    public function handle(ExamEnd $event)
    {

    }
}
