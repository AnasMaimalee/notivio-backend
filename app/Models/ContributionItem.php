<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContributionItem extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'metadata' => 'array',
    ];
    protected $fillable = [
        'contribution_id',
        'type',
        'content',
        'metadata',
    ];


    /* ================= RELATIONSHIPS ================= */

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }
}
