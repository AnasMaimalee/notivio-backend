<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* JWT methods */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function jottings()
    {
        return $this->hasMany(Jotting::class);
    }

    public function sharedJottings()
    {
        return $this->hasMany(JottingShare::class, 'shared_with');
    }
    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class);
    }
    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'contributor_id');
    }


}
