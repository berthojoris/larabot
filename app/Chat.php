<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $guarded = ['id'];

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function receive()
    {
        return $this->belongsTo('App\User', 'receive_id', 'id');
    }
}
