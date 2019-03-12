<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{ asset('css/fontchat.css') }}' rel='stylesheet' type='text/css'>
    <link href='{{ asset('css/chatfontawesome.css') }}' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
    #app {
        width: 100%;
        min-width: 360px;
        max-width: 1000px;
        height: 92vh;
        min-height: 300px;
        max-height: 720px;
    }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>