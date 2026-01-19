<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentVerificationController extends Controller
{
    public function index(): View
    {
        $pendingStudents = Student::where('registration_status', 'pending')
            ->with(['user', 'studyProgram.faculty'])
            ->latest()
            ->paginate(10);

        return view('admin-prodi.students.verification', compact('pendingStudents'));
    }

    public function show(Student $student): View
    {
        $student->load(['user', 'studyProgram.faculty']);
        return view('admin-prodi.students.verification-detail', compact('student'));
    }

    public function approve(Student $student): RedirectResponse
    {
        if ($student->registration_status !== 'pending') {
            return back()->with('error', 'Status mahasiswa tidak valid.');
        }

        // Generate NIM
        $nim = Student::generateNim($student->study_program_id, $student->year_of_entry);

        $student->update([
            'nim' => $nim,
            'registration_status' => 'approved',
        ]);

        return back()->with('success', "Mahasiswa berhasil diverifikasi. NIM: {$nim}");
    }

    public function reject(Request $request, Student $student): RedirectResponse
    {
        if ($student->registration_status !== 'pending') {
            return back()->with('error', 'Status mahasiswa tidak valid.');
        }

        $student->update([
            'registration_status' => 'rejected',
        ]);

        // Optionally deactivate user
        $student->user->update(['is_active' => false]);

        return back()->with('success', 'Pendaftaran mahasiswa ditolak.');
    }
}
