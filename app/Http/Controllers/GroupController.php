<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup()
    {
        $create = Group::create([
            'group_name' => request('group_name'),
            'admin_id' => auth()->user()->id,
        ]);
        return $create;
    }

    public function deleteGroup($uuid)
    {
        $delete = Group::whereUuid($uuid)->first()->delete();
        return $delete;
    }
}
