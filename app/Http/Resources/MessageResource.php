<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sender   = Chat::whereSenderId($this->sender_id)->with('user_from')->get()->pluck('user_from.username');
        $receiver = Chat::whereReceiverId($this->receiver_id)->with('user_to')->get()->pluck('user_to.username');
        return [
            'id'        => (int)$this->id,
            'sender_id' => $this->sender_id,
            'receiver_id'   => "receiver_id",
            "sender"    => $sender[0],
            "receiver"  => $receiver[0],
            "newSenderMessage" => $sender[0],
            "newContentMessage"   => $this->body,
            'body'   => $this->body
        ];
    }
}
