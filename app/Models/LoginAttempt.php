<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <- add this

class LoginAttempt extends Model
{
    use HasFactory; // <- add this

    protected $table = 'login_attempts';
    public $timestamps = false; // only created_at

    protected $fillable = [
        'user_id',
        'ip_address',
        'successful',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
