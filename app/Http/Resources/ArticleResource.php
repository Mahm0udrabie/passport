<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userComments = Article::whereId($this->id)
            ->with(['comments.user'=> function($q) {
            $q->whereIn('id', $this->comments->pluck('user_id'));
        }])->get();
        return [
            "id"                => $this->id,
            "date"              => $this->created_at->format('Y-m-d'),
            "time"     => $this->created_at->format('H-i-s'),
            "body"     => $this->body,
            "username" => $this->user->username,
            "name"     => $this->user->name,
            "avatar"   => $this->user->avatar,
            "comments" => CommentResource::collection($this->comments),
            "comments_count" => $this->comments->count()." ".Str::plural('comment', $this->comments->count())
       ];
    }
}
