<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PenaltyController; 
use App\Http\Controllers\MpesaController;
use Illuminate\Support\Facades\Route;


Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });



    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Protected Book Management Routes
        Route::resource('books', BookController::class);

        // Loan Management Routes
        Route::post('/books/{book}/borrow', [LoanController::class, 'borrow'])->name('loans.borrow');
        Route::patch('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');

        // Penalty Management
        Route::get('/penalties', [PenaltyController::class, 'index'])->name('penalties.index');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::post('/mpesa/stkpush', [MpesaController::class, 'initiateStkPush'])->name('mpesa.stkpush');
    });
});