<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'avatar',
        'expire',
        'email',
        'password',
        'api_token',
        'channel'
];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'expire'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function articles() {
        return $this->hasMany(Article::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function getAvatarAttribute($value) {
        return $value ?: 'https://bootdey.com/img/Content/avatar/avatar6.png';
    }
    public function user_likes() {
        return $this->hasMany(Like::class);
    }
}
