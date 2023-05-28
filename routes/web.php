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

Route::get('/', [\App\Http\Controllers\ChatController::class, "index"])
    ->name("welcome")->middleware("auth");

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::middleware('guest')->group(function (){
        Route::get("/login", "login")->name('login.init');
        Route::post("/login", "singIn")->name('login.post');
        Route::get('/register', "register")->name('register.init');
        Route::post('/register', "singUp")->name('register.post');
    });
    Route::get('/logout', "logout")->name("login.logout")->middleware('auth');
});
