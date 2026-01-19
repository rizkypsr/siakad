# SIAKAD - Panduan Developer

Dokumentasi teknis untuk memahami struktur kode dan cara kerja sistem.

---

## Struktur Folder

```
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Logic bisnis
│   │   ├── Middleware/        # Role & access control
│   │   └── Requests/          # Form validation
│   ├── Models/                # Eloquent models
│   ├── Providers/
│   └── View/
├── database/
│   ├── migrations/            # Struktur tabel
│   └── seeders/               # Data dummy
├── resources/
│   └── views/
│       ├── admin-fakultas/    # Views admin fakultas
│       ├── admin-prodi/       # Views admin prodi
│       ├── auth/              # Login & register
│       ├── components/        # Blade components
│       ├── dosen/             # Views dosen
│       ├── layouts/           # Layout utama
│       ├── mahasiswa/         # Views mahasiswa
│       └── profile/           # Halaman profile
├── routes/
│   ├── web.php                # Route utama
│   └── auth.php               # Route autentikasi
└── config/                    # Konfigurasi Laravel
```

---

## Models & Relasi

### User
```php
// app/Models/User.php
- hasOne: Student (jika role mahasiswa)
- hasOne: Lecturer (jika role dosen)
- role: admin_fakultas | admin_prodi | dosen | mahasiswa
```

### Student
```php
// app/Models/Student.php
- belongsTo: User, StudyProgram
- hasMany: Dkbs, Transcript

// Methods penting:
- getCurrentSemester()      // Hitung semester otomatis
- getCurrentAcademicYear()  // Tahun akademik aktif
- getCurrentSemesterType()  // ganjil/genap
- canCreateDkbs()           // Validasi bisa buat DKBS
- generateNim()             // Generate NIM otomatis
```

### Dkbs (Kartu Rencana Studi)
```php
// app/Models/Dkbs.php
- belongsTo: Student
- hasMany: DkbsDetail
- status: draft | submitted | approved
```

### Grade
```php
// app/Models/Grade.php
- belongsTo: DkbsDetail

// Methods:
- calculateFinalScore()   // Tugas*30% + UTS*30% + UAS*40%
- calculateGradeLetter()  // Konversi ke A-E
```

---

## Middleware

### 1. RoleMiddleware
```php
// app/Http/Middleware/RoleMiddleware.php
// Cek role user sesuai route

Route::middleware('role:admin_fakultas')->group(...)
Route::middleware('role:dosen')->group(...)
```

### 2. EnsureUserIsActive
```php
// app/Http/Middleware/EnsureUserIsActive.php
// Cek user.is_active = true

// Alias: 'active'
Route::middleware('active')->group(...)
```

### 3. EnsureStudentApproved
```php
// app/Http/Middleware/EnsureStudentApproved.php
// Cek student.registration_status = 'approved'

// Alias: 'student.approved'
Route::middleware('student.approved')->group(...)
```

---

## Controllers Utama

### DkbsController
```php
// app/Http/Controllers/DkbsController.php

// Mahasiswa:
index()   - List DKBS mahasiswa
create()  - Form buat DKBS baru
store()   - Simpan DKBS + validasi
edit()    - Form edit (hanya draft)
update()  - Update DKBS + validasi
submit()  - Submit untuk approval
destroy() - Hapus DKBS draft

// Admin Prodi:
approval() - List DKBS pending
approve()  - Setujui DKBS
reject()   - Tolak DKBS (kembali ke draft)

// Private methods:
checkScheduleConflict() - Cek jadwal bentrok
```

### GradeController
```php
// app/Http/Controllers/GradeController.php

index() - List jadwal dosen
show()  - Form input nilai per kelas
store() - Simpan nilai (skip jika locked)
lock()  - Kunci nilai (tidak bisa diubah)
```

### StudentVerificationController
```php
// app/Http/Controllers/StudentVerificationController.php

index()   - List calon mahasiswa pending
show()    - Detail calon mahasiswa
approve() - Approve + generate NIM
reject()  - Tolak pendaftaran
```

---

## Routes

### Public
```
GET  /              → Redirect ke login
GET  /login         → Form login
POST /login         → Proses login
GET  /register      → Form registrasi mahasiswa
POST /register      → Proses registrasi
POST /logout        → Logout
```

### Authenticated (semua role)
```
GET   /dashboard           → Dashboard
GET   /profile             → Edit profile
PATCH /profile             → Update profile
PATCH /profile/student     → Update info mahasiswa
DELETE /profile            → Hapus akun
```

### Admin Fakultas (`/admin-fakultas`)
```
Resource: faculties, study-programs, lecturers
```

### Admin Prodi (`/admin-prodi`)
```
Resource: curriculums, courses, schedules, students

GET  /students-verification           → List pending
GET  /students-verification/{id}      → Detail
POST /students-verification/{id}/approve
POST /students-verification/{id}/reject

GET  /dkbs/approval                   → List DKBS pending
POST /dkbs/{id}/approve
POST /dkbs/{id}/reject
```

### Dosen (`/dosen`)
```
GET  /schedules              → Jadwal mengajar
GET  /grades                 → List kelas
GET  /grades/{schedule}      → Form input nilai
POST /grades/{schedule}      → Simpan nilai
POST /grades/{schedule}/lock → Kunci nilai
```

### Mahasiswa (`/mahasiswa`)
```
Resource: dkbs (CRUD)
POST /dkbs/{id}/submit       → Submit DKBS

GET  /schedule               → Jadwal kuliah
GET  /grades                 → Lihat nilai
GET  /transcript             → Transkrip
GET  /transcript/pdf         → Download PDF
```

---

## Validasi DKBS

Lokasi: `DkbsController::store()` dan `update()`

### 1. Cek Bisa Buat DKBS
```php
$errors = $student->canCreateDkbs();
// Cek: status aktif, approved, belum ada DKBS semester ini
```

### 2. Validasi Max SKS
```php
const MAX_SKS = 24;

$totalSks = $schedules->sum(fn($s) => $s->course->sks);
if ($totalSks > self::MAX_SKS) {
    return back()->with('error', '...');
}
```

### 3. Cek Jadwal Bentrok
```php
private function checkScheduleConflict($schedules): ?string
{
    $schedulesByDay = $schedules->groupBy('day');
    
    foreach ($schedulesByDay as $day => $daySchedules) {
        $sorted = $daySchedules->sortBy('start_time')->values();
        
        for ($i = 0; $i < count($sorted) - 1; $i++) {
            $current = $sorted[$i];
            $next = $sorted[$i + 1];
            
            // Bentrok jika end_time > start_time berikutnya
            if ($current->end_time > $next->start_time) {
                return "Jadwal bentrok: ...";
            }
        }
    }
    return null;
}
```

---

## Perhitungan Otomatis

### Semester Mahasiswa
```php
// app/Models/Student.php

public function getCurrentSemester(): int
{
    $currentYear = (int) explode('/', $academicYear)[0];
    $yearDiff = $currentYear - $this->year_of_entry;
    
    // (selisih tahun * 2) + (1 ganjil / 2 genap)
    return ($yearDiff * 2) + ($semesterType === 'ganjil' ? 1 : 2);
}
```

### Generate NIM
```php
// app/Models/Student.php

public static function generateNim(int $studyProgramId, int $year): string
{
    $prefix = str_pad($studyProgramId, 2, '0', STR_PAD_LEFT);  // 01
    $yearCode = substr($year, -2);                             // 25
    
    // Cari urutan terakhir
    $lastStudent = self::where('study_program_id', $studyProgramId)
        ->whereYear('created_at', $year)
        ->whereNotNull('nim')
        ->orderBy('nim', 'desc')
        ->first();
    
    $sequence = $lastStudent ? (int)substr($lastStudent->nim, -4) + 1 : 1;
    
    return $prefix . $yearCode . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    // Output: 01250001
}
```

### Nilai Akhir
```php
// app/Models/Grade.php

public function calculateFinalScore(): float
{
    return ($this->tugas * 0.3) + ($this->uts * 0.3) + ($this->uas * 0.4);
}

public function calculateGradeLetter(): string
{
    $score = $this->final_score;
    if ($score >= 85) return 'A';
    if ($score >= 70) return 'B';
    if ($score >= 55) return 'C';
    if ($score >= 40) return 'D';
    return 'E';
}
```

---

## Seeders

### DatabaseSeeder
```bash
php artisan db:seed
```
Membuat akun default untuk semua role.

### AcademicDataSeeder
```bash
php artisan db:seed --class=AcademicDataSeeder
```
Membuat data akademik: fakultas, prodi, dosen, kurikulum, matkul, jadwal.
---

## Views & Layout

### Layout Utama
```
resources/views/layouts/
├── app.blade.php           # Layout authenticated
├── guest.blade.php         # Layout guest (login/register)
├── sidebar.blade.php       # Sidebar wrapper
├── sidebar-content.blade.php # Menu items per role
└── topbar.blade.php        # Header bar
```

### Blade Components
```
resources/views/components/
├── primary-button.blade.php
├── secondary-button.blade.php
├── danger-button.blade.php
├── text-input.blade.php
├── input-label.blade.php
├── input-error.blade.php
└── ...
```

---

## Tips Development

### Menjalankan Aplikasi
```bash
composer run dev

# Migrate database
php artisan migrate

# Fresh migrate + seed
php artisan migrate:fresh --seed
```

### Menambah Fitur Baru

1. **Buat Migration** (jika perlu tabel baru)
   ```bash
   php artisan make:migration create_xxx_table
   ```

2. **Buat Model**
   ```bash
   php artisan make:model Xxx
   ```

3. **Buat Controller**
   ```bash
   php artisan make:controller XxxController
   ```

4. **Tambah Route** di `routes/web.php`

5. **Buat Views** di `resources/views/`

### Debugging
```php
// Di controller
dd($variable);           // Dump and die
logger($variable);       // Log ke storage/logs/laravel.log

// Di blade
{{ dd($variable) }}
@dump($variable)
```

---

## File Penting

| File | Keterangan |
|------|------------|
| `routes/web.php` | Semua route aplikasi |
| `app/Models/Student.php` | Logic semester & NIM |
| `app/Http/Controllers/DkbsController.php` | Logic DKBS & validasi |
| `app/Http/Controllers/GradeController.php` | Logic input nilai |
| `bootstrap/app.php` | Registrasi middleware |
| `FITUR_SIAKAD.md` | Dokumentasi fitur lengkap |
