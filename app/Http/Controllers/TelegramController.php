<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function me()
    {
        $me = "https://api.telegram.org/bot[["+env('TELEGRAM_BOT_TOKEN')+"]]/getMe";
        $response = $client->post($me);
        return $response;
    }
}
