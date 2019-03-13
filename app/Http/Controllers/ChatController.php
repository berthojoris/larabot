<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Events\IncomingChat;
use Illuminate\Http\Request;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\UserListCollection;

class ChatController extends Controller
{
    public function list($senderID, $receiveID)
    {
        // "select * from `chat` where (`sender_id` = ? or `receive_id` = ?) and (`sender_id` = ? or `receive_id` = ?)"

        $data = Chat::with('sender', 'receive')->where(function($query) use ($senderID, $receiveID) {

            return $query->whereSenderId($senderID)->orWhere('receive_id', $senderID);

        })->where(function($query) use ($senderID, $receiveID) {

            return $query->whereSenderId($receiveID)->orWhere('receive_id', $receiveID);

        })->get();

        return ChatCollection::collection($data);
    }

    public function insert()
    {
        $received = request('receive_id');
        
        $saved = Chat::create([
            'sender_id' => request('sender_id'),
            'receive_id' => $received,
            'message' => request('message')
        ]);

        $data = Chat::with('sender', 'receive')->whereId($saved->id)->first();

        IncomingChat::dispatch($data);

        return $data;
    }

    public function online($currentID)
    {
        return UserListCollection::collection(User::where('id', '!=', $currentID)->get());
    }

    public function deleteall()
    {
        Chat::truncate();
        return "Done";
    }

    public function randomChat()
    {
        $faker = \Faker\Factory::create();
        return $faker->paragraph();
    }
}
