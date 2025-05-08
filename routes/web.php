<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TransactController;
use App\Http\Controllers\UserController;


// Page de login (GET)
Route::get('/', function () {
    Auth::logout(); 
    session()->invalidate(); 
    session()->regenerateToken(); 

    return view('login');
})->name('login');

// Formulaire d'inscription (GET)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

// Traitement du formulaire d'inscription (POST)
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Traitement du formulaire de connexion (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Déconnexion (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('transactions', TransactController::class)->names('transactions');
Route::get('/transactions-export-pdf', [TransactController::class, 'exportPDF'])->name('transactions.exportPDF');

// 🌐 Routes accessibles uniquement aux admins
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('produits', ProduitController::class)->names('produits');
    Route::resource('stocks', StockController::class)->names('stocks');
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
});

