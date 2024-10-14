<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserShareVideoEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userName;
    public $videoTitle;

    public function __construct($userName, $videoTitle)
    {
        $this->userName = $userName;
        $this->videoTitle = $videoTitle;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel("video.shared"),
        ];
    }

    public function broadcastWith()
    {
        return [
            'userName' => $this->userName,
            'videoTitle' => $this->videoTitle,
        ];
    }
}
