<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Events\FriendRequestEvent;

class FriendRequestController extends Controller
{
    public function add()
    {
        $from     = auth()->user()->id;
        $to       = request('to');

        $findUser = User::whereEmail($to)->first();
        
        if(!empty($findUser)) {
            
            $findRequest    = FriendRequest::whereFrom($from)->whereTo($to)->first();
            if(!empty($findRequest)) {

                $inserted = FriendRequest::create([
                    'from' => $from,
                    'to' => $to
                ]);

                broadcast(new FriendRequestEvent($from, $to))->toOthers();

                return response()->json([
                    'output' => 'Permintaan pertemanan berhasil dikirim',
                    'data' => $inserted
                ], 201);
                return $inserted;
            } else {
                return response()->json([
                    'output' => 'Anda sudah pernah mengirimkan permintaan pertemanan',
                    'data' => null
                ], 200);
            }
        } else {
            return response()->json([
                'output' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}
