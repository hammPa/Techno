<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PasswordResetController;

// landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Route Lupa Password
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Rute Konfirmasi Email
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware('throttle:6,1')->name('verification.send');

    // Dashboard - Wajib SUDAH Verifikasi Email (middleware verified)
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware('verified')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mua/{mua}', [DashboardController::class, 'showMua'])->name('mua.detail');

    // MUA Actions
    Route::post('/mua/profile', [DashboardController::class, 'updateProfile'])->name('mua.profile.update');
    Route::post('/mua/portfolio', [DashboardController::class, 'storePortfolio'])->name('mua.portfolio.store');
    Route::delete('/mua/portfolio/{portfolio}', [DashboardController::class, 'destroyPortfolio'])->name('mua.portfolio.destroy');

    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});