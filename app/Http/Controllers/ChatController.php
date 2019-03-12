<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use App\Http\Resources\ChatCollection;

class ChatController extends Controller
{
    public function list($senderID, $receiveID)
    {
        return ChatCollection::collection(Chat::whereSenderId($senderID)->whereReceiveId($receiveID)->get());
    }

    public function insert()
    {
        $saved = Chat::create([
            'sender_id' => 1,
            'receive_id' => 2,
            'message' => request('message')
        ]);

        return $saved;
    }
}
