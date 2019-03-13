<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IncomingChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pushchat;
    public $receID;

    public function __construct($data, $receiveID)
    {
        $this->pushchat = $data;
        $this->received   = $receiveID;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('pushchat.'.$this->received);
    }
}
