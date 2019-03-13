<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('pushchat', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Allow channel access only for authenticated user
Broadcast::channel('onlyloggeduser', function ($user) {
    return auth()->check();
});

// Allow channel access only for authenticated user and return list user
Broadcast::channel('online', function ($user) {
    if (auth()->check()) {
        logger($user->toArray());
        return $user->toArray();
    }
    // return ['name' => $user->name];
});

Broadcast::channel('pushchat', function ($user) {
    return ['name' => $user->name];
});
