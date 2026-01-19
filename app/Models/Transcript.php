<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transcript extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester',
        'gpa',
        'cgpa',
    ];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
            'gpa' => 'decimal:2',
            'cgpa' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
