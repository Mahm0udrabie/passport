<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'body',
        'is_opened'
    ];
    public function user_from()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function user_to()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
