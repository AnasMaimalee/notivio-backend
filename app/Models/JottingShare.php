<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JottingShare extends Model
{
    use HasFactory;

    protected $table = 'jotting_shares';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'jotting_id',
        'shared_with',
        'permission',
    ];

    /* =====================
        RELATIONSHIPS
    ====================== */

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}
