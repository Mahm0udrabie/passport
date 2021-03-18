<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfile extends Controller
{
    public function index(User $user) {
        return response()->json([
            "status" => "success",
            "data"  => $user,
        ]);
    }
}
