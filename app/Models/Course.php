<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $fillable = ['title', 'description', 'user_id'];

    // Relationship: course belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: course has many jottings
    public function jottings()
    {
        return $this->hasMany(Jotting::class);
    }
}
