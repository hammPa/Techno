<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\ScheduleController;
use App\Models\User;


// landing page
Route::get('/', function (\Illuminate\Http\Request $request) {
    $search = $request->query('q');
    $category = $request->query('category');

    $muaList = User::where('role', 'mua')
        ->whereNotNull('email_verified_at')
        ->whereHas('muaProfile', function ($query) {
            $query->where('verification_status', 'verified');
        })
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('muaProfile', function ($qp) use ($search) {
                      $qp->where('studio_name', 'like', "%{$search}%")
                         ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        })
        ->when($category, function ($query, $category) {
            $query->whereHas('services', function ($q) use ($category) {
                $q->where('category', $category);
            });
        })
        ->with(['muaProfile', 'services', 'portfolios'])
        ->withCount('muaReviews')
        ->withAvg('muaReviews', 'rating')
        ->latest()
        ->take(9)
        ->get();

    return view('welcome', compact('muaList', 'search', 'category'));
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
        // Upload Identitas / KTP
        Route::post('/mua/verify-identity', [DashboardController::class, 'uploadIdCard'])->name('mua.identity.upload');

        Route::put('/mua/schedules', [ScheduleController::class, 'update'])->name('mua.schedules.update');

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

        // Rute Beri Ulasan (Review)
        Route::post('/bookings/{booking}/reviews', [BookingController::class, 'storeReview'])->name('reviews.store');
    });

    // KHUSUS MUA DAN CLIENT
    Route::middleware('role:mua,client')->group(function () {
        // Jadwal Booking
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

        // cancel user
        Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });


    // KHUSUS ADMIN
    Route::middleware('role:admin')->group(function () {
        // Aksi verifikasi KTP oleh Admin
        Route::patch('/admin/mua/{muaProfile}/verify', [DashboardController::class, 'verifyMua'])->name('admin.mua.verify');
        Route::patch('/admin/mua/{muaProfile}/reject', [DashboardController::class, 'rejectMua'])->name('admin.mua.reject');
    
        // Verifikasi Pembayaran oleh Admin
        Route::patch('/admin/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
    
        // Tambahkan route reject ini:
        Route::patch('/admin/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
        
        // Route Verifikasi Penarikan untuk Admin
        Route::patch('/admin/payouts/{payout}/approve', [PayoutController::class, 'approve'])->name('admin.payouts.approve');
        Route::patch('/admin/payouts/{payout}/reject', [PayoutController::class, 'reject'])->name('admin.payouts.reject');
    });



});