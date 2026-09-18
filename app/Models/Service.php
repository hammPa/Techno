<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'price',
        'duration_minutes',
        'description',
    ];

    // Relasi balik: Tiap paket rias dimiliki oleh 1 User (MUA)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}