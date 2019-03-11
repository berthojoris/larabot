<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function me()
    {
        $response = Telegram::getMe();
        
        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        return $botId;
    }
}
