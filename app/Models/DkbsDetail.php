<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DkbsDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'dkbs_id',
        'schedule_id',
    ];

    public function dkbs(): BelongsTo
    {
        return $this->belongsTo(Dkbs::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class);
    }
}
