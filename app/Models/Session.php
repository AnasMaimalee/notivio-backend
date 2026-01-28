<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions'; // match the existing table
    protected $primaryKey = 'id';
    public $incrementing = false; // because the ID is a string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    // Relation to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
