<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receive_id' => $this->receive_id,
            'image' => ($this->sender_id == 1) ? 'images/man1.png' : 'images/man2.png',
            'type' => ($this->sender_id == 1) ? 'sent' : 'replies',
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
