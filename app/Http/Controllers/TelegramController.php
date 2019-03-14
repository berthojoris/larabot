<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function me()
    {
        // $env = env('TELEGRAM_BOT_TOKEN');
        // $client = new \GuzzleHttp\Client();
        // $res = $client->request('GET', "https://api.telegram.org/bot707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A/getMe");
        // return json_decode($res->getBody(), true);

        $response = Telegram::getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        dd($response);
    }

    public function sendmsg()
    {
        $response = Telegram::sendMessage([
            'chat_id' => '@berthojoris', 
            'text' => 'Hai Bertho'
        ]);
        $messageId = $response->getMessageId();

        return $response;
    }
}
