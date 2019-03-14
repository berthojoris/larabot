<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OnlineStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pushchat, $type;

    public function __construct($data, $typeMsg)
    {
        $this->pushchat = $data;
        $this->type = $typeMsg;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PresenceChannel('online');
    }
}
