<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\UserListCollection;

class ChatController extends Controller
{
    public function list($senderID, $receiveID)
    {
        return ChatCollection::collection(Chat::whereSenderId($senderID)->whereReceiveId($receiveID)->get());
    }

    public function insert()
    {
        $saved = Chat::create([
            'sender_id' => request('sender_id'),
            'receive_id' => 2,
            'message' => request('message')
        ]);

        return $saved;
    }

    public function online($currentID)
    {
        return UserListCollection::collection(User::where('id', '!=', $currentID)->get());
    }
}
