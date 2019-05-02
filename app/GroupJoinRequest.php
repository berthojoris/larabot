<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupJoinRequest extends Model
{
    protected $guarded = ['id'];

    public function asking()
    {
        return $this->belongsTo('App\User', 'user_asking', 'id');
    }

    public function request()
    {
        return $this->belongsTo('App\User', 'user_request', 'id');
    }
}
