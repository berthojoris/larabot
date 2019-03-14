<?php

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
