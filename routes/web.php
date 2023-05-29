<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(\App\Http\Controllers\ChatController::class)->middleware('auth')->group(function () {
    Route::get('/', "index")->name("welcome");
    Route::prefix('/chats')->group(function () {
        Route::post('/', "searchChats")->name("chat.search");
        Route::post("/add", "addChat")->name("chat.add");
        Route::post("/new", "createGroupChat")->name("chat.new");
        Route::prefix('/message')->group(function () {
            Route::post("/", "getChatHistory")->name("message.history");
        });
    });
    Route::post('/user', "searchUserByName")->name('user.search');
});


Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::middleware('guest')->group(function (){
        Route::get("/login", "login")->name('login.init');
        Route::post("/login", "singIn")->name('login.post');
        Route::get('/register', "register")->name('register.init');
        Route::post('/register', "singUp")->name('register.post');
    });
    Route::get('/logout', "logout")->name("login.logout")->middleware('auth');
});
