<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function me()
    {
        $env = env('TELEGRAM_BOT_TOKEN');
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "https://api.telegram.org/bot707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A/getMe");
        return json_decode($res->getBody(), true);
    }
}
