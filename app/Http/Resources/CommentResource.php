<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment_id' => $this->id,
            'article_id' => $this->article_id,
            'comment'    => $this->comment,
            'date'       => $this->created_at->format('Y-m-d'),
            'time'       => $this->created_at->format('H-i-s'),
            'username'       => $this->user->username,
            'avatar'       => $this->user->avatar
        ];
    }
}
