<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function me()
    {
        $me = "https://api.telegram.org/bot[[707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A]]/getMe";
        $response = $client->post($me);
        return $response;
    }
}
