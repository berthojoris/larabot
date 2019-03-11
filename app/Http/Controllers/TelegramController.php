<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function me()
    {
        $client = new \GuzzleHttp\Client();
        $getMe = "https://api.telegram.org/bot707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A/getMe";
        $response = $client->get($getMe);
        return response()->json($response->getBody());

        // $response = Telegram::getMe();

        // $botId = $response->getId();
        // $firstName = $response->getFirstName();
        // $username = $response->getUsername();

        // return response()->json($botId);
    }
}
