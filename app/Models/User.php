<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relations
    public function muaProfile()
    {
        return $this->hasOne(MuaProfile::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }


    // Booking yang diajukan oleh user sebagai Klien
    public function clientBookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    // Booking yang diterima oleh user sebagai MUA
    public function muaBookings()
    {
        return $this->hasMany(Booking::class, 'mua_id');
    }


    
    // 2 ini payout
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    // Menghitung sisa saldo bersih MUA yang bisa ditarik
    public function getAvailableBalanceAttribute()
    {
        // Total penghasilan dari booking yang sudah 'completed'
        $totalEarned = $this->muaBookings()
            ->where('status', 'completed')
            ->sum('total_price');

        // Total dana yang sudah ditarik (completed) atau sedang proses (pending)
        $totalWithdrawn = $this->payouts()
            ->whereIn('status', ['pending', 'completed'])
            ->sum('amount');

        return max(0, $totalEarned - $totalWithdrawn);
    }

    public function muaReviews()
    {
        return $this->hasMany(Review::class, 'mua_id');
    }

    public function schedules()
    {
        return $this->hasMany(MuaSchedule::class);
    }
}
