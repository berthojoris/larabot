<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $chatFrom;
    public $chatTo;

    public function __construct($typeMsg)
    {
        $this->type = $typeMsg;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }
}
