<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListCollection extends JsonResource
{

    public function toArray($request)
    {
        if(is_null($this->lastChat)) {
            $msg = 'No chat history...';
        } else {
            $msg = $this->lastChat->message;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'last_message' => $msg,
            'unread' => 0
        ];
    }
}
