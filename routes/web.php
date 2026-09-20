<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayoutController;
use App\Models\User;


// landing page
Route::get('/', function () {
    $muaList = User::where('role', 'mua')
        ->whereNotNull('email_verified_at')
        ->with(['muaProfile', 'services', 'portfolios'])
        ->latest()
        ->take(6) // Tampilkan 6 MUA unggulan untuk landing page
        ->get();

    return view('welcome', compact('muaList'));
})->name('home');


Route::get('/mua/{mua}', [DashboardController::class, 'showMua'])->name('mua.detail');

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


    Route::get('/profile', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [DashboardController::class, 'updateAccount'])->name('profile.update');
    

    // KHUSUS MUA
    Route::middleware('role:mua')->group(function () {
        Route::post('/mua/profile', [DashboardController::class, 'updateProfile'])->name('mua.profile.update');
        Route::post('/mua/portfolio', [DashboardController::class, 'storePortfolio'])->name('mua.portfolio.store');
        Route::delete('/mua/portfolio/{portfolio}', [DashboardController::class, 'destroyPortfolio'])->name('mua.portfolio.destroy');

        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::patch('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    
        // Selesaikan Booking oleh MUA dengan Kode 4 Digit
        Route::post('/bookings/{booking}/complete', [BookingController::class, 'completeWithCode'])->name('bookings.complete');

        // Route Penarikan untuk MUA
        Route::post('/mua/payouts', [PayoutController::class, 'store'])->name('mua.payouts.store');
    });

    // KHUSUS CLIENT
    Route::middleware('role:client')->group(function () {
        // Rute Reservasi
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

        // Upload Bukti Bayar oleh Klien
        Route::post('/bookings/{booking}/payments', [PaymentController::class, 'store'])->name('payments.store');
    });

    // KHUSUS MUA DAN CLIENT
    Route::middleware('role:mua,client')->group(function () {
        // Jadwal Booking
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    });


    // KHUSUS ADMIN
    Route::middleware('role:admin')->group(function () {
        // Verifikasi Pembayaran oleh Admin
        Route::patch('/admin/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
    
        // Tambahkan route reject ini:
        Route::patch('/admin/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
        
        // Route Verifikasi Penarikan untuk Admin
        Route::patch('/admin/payouts/{payout}/approve', [PayoutController::class, 'approve'])->name('admin.payouts.approve');
        Route::patch('/admin/payouts/{payout}/reject', [PayoutController::class, 'reject'])->name('admin.payouts.reject');
    });



});