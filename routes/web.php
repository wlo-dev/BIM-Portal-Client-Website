<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// only for guest user and people who are not logged in
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->middleware('throttle:10,1');

    Route::get('/login',[AuthController::class, 'showlogin'])->name('login');
    Route::post('/login',[AuthController::class, 'login'])->middleware('throttle:5,1');

});

// Only for logged-in people
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/account',[AccountController::class,'show'])->name('account');
        Route::put('/account',[AccountController::class,'update'])->name('account.update');
    });