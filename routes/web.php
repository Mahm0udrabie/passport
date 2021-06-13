<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/redirect/{service}', "App\Http\Controllers\SocialController@redirect");
Route::get('/callback/{service}', "App\Http\Controllers\SocialController@callback");
Route::get("/terms", function() {
    echo "<h1>terms</h1>";
});

Route::get("/privacy", function() {
    echo "<h1>privacy</h1>";
});


Auth::routes(['verify'=> true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home') -> middleware('verified');


// Route::get('/index', [ArticleController::class, "index"]);
Route::get('/users', [ArticleController::class, "show_users"])->middleware('auth:api');
