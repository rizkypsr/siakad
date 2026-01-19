<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LecturerController extends Controller
{
    public function index(): View
    {
        $lecturers = Lecturer::with(['user', 'studyProgram'])->latest()->paginate(10);
        return view('admin-fakultas.lecturers.index', compact('lecturers'));
    }

    public function create(): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-fakultas.lecturers.create', compact('studyPrograms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nidn' => 'required|string|max:20|unique:lecturers',
            'study_program_id' => 'required|exists:study_programs,id',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'is_active' => true,
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
                'study_program_id' => $validated['study_program_id'],
            ]);
        });

        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(Lecturer $lecturer): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-fakultas.lecturers.edit', compact('lecturer', 'studyPrograms'));
    }

    public function update(Request $request, Lecturer $lecturer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lecturer->user_id,
            'nidn' => 'required|string|max:20|unique:lecturers,nidn,' . $lecturer->id,
            'study_program_id' => 'required|exists:study_programs,id',
        ]);

        DB::transaction(function () use ($validated, $lecturer) {
            $lecturer->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $lecturer->update([
                'nidn' => $validated['nidn'],
                'study_program_id' => $validated['study_program_id'],
            ]);
        });

        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil diperbarui.');
    }

    public function destroy(Lecturer $lecturer): RedirectResponse
    {
        $lecturer->user->delete();
        return redirect()->route('lecturers.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
