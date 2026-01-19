<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with(['user', 'studyProgram'])->latest()->paginate(10);
        return view('admin-prodi.students.index', compact('students'));
    }

    public function create(): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-prodi.students.create', compact('studyPrograms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'required|string|max:20|unique:students',
            'study_program_id' => 'required|exists:study_programs,id',
            'year_of_entry' => 'required|integer|min:2000|max:2100',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'is_active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'study_program_id' => $validated['study_program_id'],
                'year_of_entry' => $validated['year_of_entry'],
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-prodi.students.edit', compact('student', 'studyPrograms'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'nim' => 'required|string|max:20|unique:students,nim,' . $student->id,
            'study_program_id' => 'required|exists:study_programs,id',
            'year_of_entry' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,cuti,lulus',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'nim' => $validated['nim'],
                'study_program_id' => $validated['study_program_id'],
                'year_of_entry' => $validated['year_of_entry'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->user->delete();
        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
