<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    Auth::logout(); 
    session()->invalidate(); 
    session()->regenerateToken(); 

    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');