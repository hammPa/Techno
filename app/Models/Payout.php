<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'account_number',
        'account_holder',
        'status',
        'proof_image',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}