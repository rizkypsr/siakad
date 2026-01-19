<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudyProgramController extends Controller
{
    public function index(): View
    {
        $studyPrograms = StudyProgram::with('faculty')->latest()->paginate(10);
        return view('admin-fakultas.study-programs.index', compact('studyPrograms'));
    }

    public function create(): View
    {
        $faculties = Faculty::all();
        return view('admin-fakultas.study-programs.create', compact('faculties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'code' => 'required|string|max:10|unique:study_programs',
            'name' => 'required|string|max:255',
            'degree' => 'required|in:D3,S1,S2,S3',
        ]);

        StudyProgram::create($validated);

        return redirect()->route('study-programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(StudyProgram $studyProgram): View
    {
        $faculties = Faculty::all();
        return view('admin-fakultas.study-programs.edit', compact('studyProgram', 'faculties'));
    }

    public function update(Request $request, StudyProgram $studyProgram): RedirectResponse
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'code' => 'required|string|max:10|unique:study_programs,code,' . $studyProgram->id,
            'name' => 'required|string|max:255',
            'degree' => 'required|in:D3,S1,S2,S3',
        ]);

        $studyProgram->update($validated);

        return redirect()->route('study-programs.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(StudyProgram $studyProgram): RedirectResponse
    {
        $studyProgram->delete();
        return redirect()->route('study-programs.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
