<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Events\IncomingChat;
use App\Events\OnlineStatus;
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

    public function insert(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'receive_id' => 'required',
            'message' => 'required'
        ]);
        
        $saved = Chat::create([
            'sender_id' => request('sender_id'),
            'receive_id' => request('receive_id'),
            'message' => request('message')
        ]);

        $data = Chat::with('sender', 'receive')->whereId($saved->id)->first();

        broadcast(new OnlineStatus($data, 'insert'))->toOthers();

        return $data;
    }

    public function online($currentID)
    {
        return UserListCollection::collection(User::where('id', '!=', $currentID)->get());
    }

    public function deleteall()
    {
        Chat::truncate();
        broadcast(new OnlineStatus(null, 'clean'));
        return "Done";
    }

    public function randomChat()
    {
        $faker = \Faker\Factory::create();
        return $faker->paragraph();
    }
}
