<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class SocialController extends Controller
{
    public function redirect($service) {
        return Socialite::driver($service)->redirect(); 
    }

    public function callback($service) {
       $facebookDate = Socialite::with($service) -> user();
    //    return response() -> json($facebookDate);
       try{
         $user = User::where('email', $facebookDate->email)
         ->orWhere('email',$facebookDate->name."@passport.com")
         ->firstOrFail();
    } catch (ModelNotFoundException $e) {
     
       $user = User::create([
            "username" => $facebookDate->name,
            "name" => $facebookDate->name,
            "email" => $facebookDate->email ? $facebookDate->email : $facebookDate->name."@passport.com",
            'password' => Hash::make($facebookDate->name.$facebookDate->email),
            'remember_token' => $facebookDate->token
        ]);
        // dd($create);
    }
        Auth::login($user);
        return redirect("/home");
    }
}
