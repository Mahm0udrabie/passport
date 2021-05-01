<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [ 'name', 'user_id', 'body'];
    protected $hidden = ['created_at', 'updated_at'];
    
}
