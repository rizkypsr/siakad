<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dkbs extends Model
{
    use HasFactory;

    protected $table = 'dkbs';

    protected $fillable = [
        'student_id',
        'academic_year',
        'semester',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DkbsDetail::class);
    }

    public function getTotalSksAttribute(): int
    {
        return $this->details->sum(fn ($detail) => $detail->schedule->course->sks ?? 0);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
