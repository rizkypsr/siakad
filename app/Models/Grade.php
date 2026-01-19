<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'dkbs_detail_id',
        'tugas',
        'uts',
        'uas',
        'final_score',
        'grade_letter',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'tugas' => 'decimal:2',
            'uts' => 'decimal:2',
            'uas' => 'decimal:2',
            'final_score' => 'decimal:2',
            'is_locked' => 'boolean',
        ];
    }

    public function dkbsDetail(): BelongsTo
    {
        return $this->belongsTo(DkbsDetail::class);
    }

    public function calculateFinalScore(): float
    {
        // Bobot: Tugas 30%, UTS 30%, UAS 40%
        return ($this->tugas * 0.3) + ($this->uts * 0.3) + ($this->uas * 0.4);
    }

    public function calculateGradeLetter(): string
    {
        $score = $this->final_score ?? $this->calculateFinalScore();

        return match (true) {
            $score >= 85 => 'A',
            $score >= 70 => 'B',
            $score >= 55 => 'C',
            $score >= 40 => 'D',
            default => 'E',
        };
    }

    public function getGradePoint(): float
    {
        return match ($this->grade_letter) {
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            default => 0.0,
        };
    }
}
