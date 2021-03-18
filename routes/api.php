<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Profile\UserProfile;
use App\Models\Chat;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/logout', [ApiAuthController::class,'logout'])->name('logout.api');
});
Route::group(['middleware' => ['cors', 'json']], function () {
    Route::post('/login', [ApiAuthController::class, "login"] )->name('login.api');
    Route::post('/register',[ApiAuthController::class,'register'])->name('register.api');
    Route::post('/logout', [ApiAuthController::class,'logout'])->name('logout.api');
    Route::post('messages/add',[MessagesController::class, 'send']); 
    Route::get('messages/users/{id}', [MessagesController::class, 'messages']);
    Route::get('/messages',  [MessagesController::class, 'chats']);
    Route::get("/profile/{user:username}", [UserProfile::class, "index"])->name('user.profile');
});

