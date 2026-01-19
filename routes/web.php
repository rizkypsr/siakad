<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'active'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/student', [ProfileController::class, 'updateStudent'])->name('profile.student.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Fakultas Routes
    Route::middleware('role:admin_fakultas')->prefix('admin-fakultas')->group(function () {
        Route::resource('faculties', \App\Http\Controllers\FacultyController::class);
        Route::resource('study-programs', \App\Http\Controllers\StudyProgramController::class);
        Route::resource('lecturers', \App\Http\Controllers\LecturerController::class);
    });

    // Admin Prodi Routes
    Route::middleware('role:admin_prodi')->prefix('admin-prodi')->group(function () {
        Route::resource('curriculums', \App\Http\Controllers\CurriculumController::class);
        Route::resource('courses', \App\Http\Controllers\CourseController::class);
        Route::resource('schedules', \App\Http\Controllers\ScheduleController::class);
        Route::resource('students', \App\Http\Controllers\StudentController::class);
        
        // Verifikasi Calon Mahasiswa
        Route::get('students-verification', [\App\Http\Controllers\StudentVerificationController::class, 'index'])->name('students.verification.index');
        Route::get('students-verification/{student}', [\App\Http\Controllers\StudentVerificationController::class, 'show'])->name('students.verification.show');
        Route::post('students-verification/{student}/approve', [\App\Http\Controllers\StudentVerificationController::class, 'approve'])->name('students.verification.approve');
        Route::post('students-verification/{student}/reject', [\App\Http\Controllers\StudentVerificationController::class, 'reject'])->name('students.verification.reject');
        
        Route::get('dkbs/approval', [\App\Http\Controllers\DkbsController::class, 'approval'])->name('dkbs.approval');
        Route::post('dkbs/{dkbs}/approve', [\App\Http\Controllers\DkbsController::class, 'approve'])->name('dkbs.approve');
        Route::post('dkbs/{dkbs}/reject', [\App\Http\Controllers\DkbsController::class, 'reject'])->name('dkbs.reject');
    });

    // Dosen Routes
    Route::middleware('role:dosen')->prefix('dosen')->group(function () {
        Route::get('schedules', [\App\Http\Controllers\LecturerScheduleController::class, 'index'])->name('lecturer.schedules');
        Route::get('grades', [\App\Http\Controllers\GradeController::class, 'index'])->name('grades.index');
        Route::get('grades/{schedule}', [\App\Http\Controllers\GradeController::class, 'show'])->name('grades.show');
        Route::post('grades/{schedule}', [\App\Http\Controllers\GradeController::class, 'store'])->name('grades.store');
        Route::post('grades/{schedule}/lock', [\App\Http\Controllers\GradeController::class, 'lock'])->name('grades.lock');
    });

    // Mahasiswa Routes
    Route::middleware(['role:mahasiswa', 'student.approved'])->prefix('mahasiswa')->group(function () {
        Route::resource('dkbs', \App\Http\Controllers\DkbsController::class)->except(['approval', 'approve', 'reject'])->parameters(['dkbs' => 'dkbs']);
        Route::post('dkbs/{dkbs}/submit', [\App\Http\Controllers\DkbsController::class, 'submit'])->name('dkbs.submit');
        Route::get('schedule', [\App\Http\Controllers\StudentScheduleController::class, 'index'])->name('student.schedule');
        Route::get('grades', [\App\Http\Controllers\StudentGradeController::class, 'index'])->name('student.grades');
        Route::get('transcript', [\App\Http\Controllers\TranscriptController::class, 'index'])->name('student.transcript');
        Route::get('transcript/pdf', [\App\Http\Controllers\TranscriptController::class, 'downloadPdf'])->name('student.transcript.pdf');
    });
});

require __DIR__.'/auth.php';
