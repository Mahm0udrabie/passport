<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreatePostArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "date"    => $this->created_at->format('Y-m-d'),
            "time"    => $this->created_at->format('H-i-s'),
            "body"    => $this->body,
            "username" => $this->user->username,
            "name" => $this->user->name,
            "avatar" => $this->user->avatar,
        ];
    }
}
