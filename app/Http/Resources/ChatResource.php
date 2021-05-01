<?php

namespace App\Http\Resources;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $sender   = Chat::whereSenderId($this->sender_id)->with('user_from')->get()->pluck('user_from.username');
        $receiver = Chat::whereReceiverId($this->receiver_id)->with('user_to')->get()->pluck('user_to.username');
        return [
            "id"        => $this->id,
            "sender"    => $sender[0],
            "receiver"  => $receiver[0],
            "newSenderMessage" => $sender[0],
            "newContentMessage"   => $this->body,
            "content"   => $this->body,
            "is_viewed" => $this->is_opened,
            "sent"      => $this->created_at->format('y-d-m H:i:s'),
        ];
    }
}
