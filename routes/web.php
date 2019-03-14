<?php

use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/chat', 'chat')->middleware('auth');
Route::get('user/online', 'ChatController@online');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/delete', 'ChatController@deleteall');
Route::get('/randomchat', 'ChatController@randomChat');

//TELEGRAM
Route::get('/me', 'TelegramController@me');
Route::get('/sendmsg', 'TelegramController@sendmsg');
Route::post('/707434480:AAGsDoc4tSudDB1F4nWKGXYKDyQxHi4tL7A/webhook', function () {
    $update = Telegram::commandsHandler(true);
	
	// Commands handler method returns an Update object.
	// So you can further process $update object 
	// to however you want.
	
    return 'ok';
});
