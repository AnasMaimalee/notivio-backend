<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'id',
        'jotting_id',
        'filename',
        'path',
        'type',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }
}
