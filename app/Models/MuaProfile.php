<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studio_name',
        'city',
        'bio',
        'instagram_username',
        'id_card_url',
        'verification_status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}