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
    public function chatHistory()
    {
        $senderID   = auth()->user()->id;
        $receiveID  = request('receiverID');

        $data = Chat::with('sender', 'receive')->where(function($query) use ($senderID, $receiveID) {
            return $query->whereSenderId($senderID)->orWhere('receive_id', $senderID);
        })->where(function($query) use ($senderID, $receiveID) {
            return $query->whereSenderId($receiveID)->orWhere('receive_id', $receiveID);
        })->get();
        return ChatCollection::collection($data);
    }

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
        $saved = Chat::create([
            'sender_id' => auth()->user()->id,
            'receive_id' => request('receive_id'),
            'message' => request('message')
        ]);

        $data = Chat::with('sender', 'receive')->whereId($saved->id)->first();

        $newData = [
            'id' => $data->id,
            'sender_id' => $data->sender_id,
            'receive_id' => $data->receive_id,
            'sender_image' => $data->sender->image,
            'receive_image' => $data->receive->image,
            'message' => $data->message,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];

        broadcast(new IncomingChat($newData, 'insert'))->toOthers();

        return $newData;
    }

    public function online($currentID)
    {
        return UserListCollection::collection(User::where('id', '!=', $currentID)->get());
    }

    public function deleteall()
    {
        Chat::truncate();
        broadcast(new IncomingChat(null, 'clean'));
        return "Done";
    }

    public function randomChat()
    {
        $faker = \Faker\Factory::create();
        return $faker->paragraph();
    }
}
