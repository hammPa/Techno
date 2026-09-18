<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'mua_id',
        'service_id',
        'booking_date',
        'booking_time',
        'location_address',
        'total_price',
        'status',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function mua()
    {
        return $this->belongsTo(User::class, 'mua_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}