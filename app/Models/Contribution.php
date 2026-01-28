<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contribution extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'jotting_id',
        'contributor_id',
        'status',
        'message',
        'reviewed_by',
        'reviewed_at',
    ];

    /* ================= RELATIONSHIPS ================= */

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }

    public function contributor()
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function items()
    {
        return $this->hasMany(ContributionItem::class);
    }

    public function jotting()
    {
        return $this->belongsTo(Jotting::class);
    }

}
