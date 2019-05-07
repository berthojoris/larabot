<?php

use Carbon\Carbon;
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

Route::get('/carbon', function () {
    $datetime = Carbon::now();
    $output = $datetime->toDateTimeString();

    $dt = Carbon::create($output);
    $fiveDays = $dt->addDays(2)->toDateTimeString();

    return $fiveDays;
});

Route::view('chat', 'chat')->middleware('auth');
Route::get('user/online', 'ChatController@online');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('delete', 'ChatController@deleteall');
Route::get('randomchat', 'ChatController@randomChat');
Route::post('group/create', 'GroupController@createGroup');
Route::post('friend/request', 'FriendRequestController@add');
Route::post('user', 'HomeController@getUser');
Route::post('chat/history', 'ChatController@chatHistory');
Route::post('chat/insert', 'ChatController@insert');
Route::get('user/online', 'ChatController@online');
Route::get('chat/set/read', 'ChatController@read');
Route::get('chat/get/unread', 'ChatController@getAllUnread');