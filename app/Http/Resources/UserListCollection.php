<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_null($this->lastChat)) {
            $msg = 'No replies';
        } else {
            $msg = $this->lastChat->message;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'last_message' => $msg,
            'is_read' => 0
        ];
    }
}
