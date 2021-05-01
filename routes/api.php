<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\CommentController;
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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
    Route::get('/index', [ArticleController::class, "index"]);  
    Route::post('/posts/add_post', [ArticleController::class, "create"]);  
    Route::post('/post/comment/add_comment', [CommentController::class, "create"]);  
    Route::get('/post/comments', [CommentController::class, "index"]);  
});

