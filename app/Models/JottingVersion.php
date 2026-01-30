<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JottingVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'jotting_id',
        'edited_by',
        'content',
        'version',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
