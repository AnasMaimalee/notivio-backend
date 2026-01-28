<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jotting extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'jottings';

    protected $keyType = 'string';
    public $incrementing = false;


    

    protected $fillable = [
        'id',
        'course_id',
        'user_id',
        'title',
        'content',
        'voice_path',
        'sketch_data',
    ];

    protected $casts = [
        'sketch_data' => 'array',
    ];

    /* =====================
        RELATIONSHIPS
    ====================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function versions()
    {
        return $this->hasMany(JottingVersion::class);
    }

    public function shares()
    {
        return $this->hasMany(JottingShare::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

}
