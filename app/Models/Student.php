<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'study_program_id',
        'year_of_entry',
        'status',
        'registration_status',
        'phone',
        'address',
        'birth_date',
        'birth_place',
        'gender',
    ];

    protected function casts(): array
    {
        return [
            'year_of_entry' => 'integer',
            'birth_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function dkbs(): HasMany
    {
        return $this->hasMany(Dkbs::class);
    }

    public function transcripts(): HasMany
    {
        return $this->hasMany(Transcript::class);
    }

    public function isPending(): bool
    {
        return $this->registration_status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->registration_status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->registration_status === 'rejected';
    }

    public static function generateNim(int $studyProgramId, int $year): string
    {
        $prefix = str_pad($studyProgramId, 2, '0', STR_PAD_LEFT);
        $yearCode = substr($year, -2);
        
        $lastStudent = self::where('study_program_id', $studyProgramId)
            ->whereYear('created_at', $year)
            ->whereNotNull('nim')
            ->orderBy('nim', 'desc')
            ->first();

        $sequence = 1;
        if ($lastStudent && $lastStudent->nim) {
            $lastSequence = (int) substr($lastStudent->nim, -4);
            $sequence = $lastSequence + 1;
        }

        return $prefix . $yearCode . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Hitung semester mahasiswa saat ini berdasarkan tahun masuk
     * Formula: (tahun_akademik - tahun_masuk) * 2 + (1 jika ganjil, 2 jika genap)
     */
    public function getCurrentSemester(?string $academicYear = null, ?string $semesterType = null): int
    {
        $academicYear = $academicYear ?? self::getCurrentAcademicYear();
        $semesterType = $semesterType ?? self::getCurrentSemesterType();

        // Extract tahun awal dari academic year (e.g., "2024/2025" -> 2024)
        $currentYear = (int) explode('/', $academicYear)[0];
        $yearDiff = $currentYear - $this->year_of_entry;

        // Semester = (selisih tahun * 2) + (1 untuk ganjil, 2 untuk genap)
        $semester = ($yearDiff * 2) + ($semesterType === 'ganjil' ? 1 : 2);

        return max(1, $semester); // Minimal semester 1
    }

    /**
     * Get current academic year (e.g., "2024/2025")
     */
    public static function getCurrentAcademicYear(): string
    {
        $month = (int) date('n');
        $year = (int) date('Y');

        // Tahun akademik dimulai bulan Agustus/September
        // Jika bulan 1-7, masih tahun akademik sebelumnya
        if ($month < 8) {
            return ($year - 1) . '/' . $year;
        }

        return $year . '/' . ($year + 1);
    }

    /**
     * Get current semester type (ganjil/genap)
     */
    public static function getCurrentSemesterType(): string
    {
        $month = (int) date('n');

        // Ganjil: Agustus - Januari (8-12, 1)
        // Genap: Februari - Juli (2-7)
        if ($month >= 2 && $month <= 7) {
            return 'genap';
        }

        return 'ganjil';
    }

    /**
     * Check if student can create DKBS
     */
    public function canCreateDkbs(): array
    {
        $errors = [];

        // Check status aktif
        if ($this->status !== 'aktif') {
            $errors[] = 'Status mahasiswa tidak aktif.';
        }

        // Check registration approved
        if ($this->registration_status !== 'approved') {
            $errors[] = 'Akun belum diverifikasi.';
        }

        // Check if DKBS already exists for current semester
        $academicYear = self::getCurrentAcademicYear();
        $semester = $this->getCurrentSemester();

        $existingDkbs = $this->dkbs()
            ->where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->first();

        if ($existingDkbs) {
            $errors[] = "DKBS untuk semester {$semester} tahun akademik {$academicYear} sudah ada.";
        }

        return $errors;
    }
}
