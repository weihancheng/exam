<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExamEnd
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $exam_room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($exam_room)
    {
        $this->exam_room = $exam_room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getExamRoom()
    {
        return $this->exam_room;
    }
}
