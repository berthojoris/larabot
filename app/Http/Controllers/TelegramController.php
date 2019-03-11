<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function me()
    {
        $client = new \GuzzleHttp\Client();
        $me = "https://api.telegram.org/bot707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A/getMe";
        $response = $client->post($me);
        var_dump($response);
    }
}
