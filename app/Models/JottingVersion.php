<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JottingVersion extends Model
{
    use HasFactory;

    protected $table = 'jotting_versions';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'jotting_id',
        'edited_by',
        'content',
        'version',
    ];

    /* =====================
        RELATIONSHIPS
    ====================== */

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
