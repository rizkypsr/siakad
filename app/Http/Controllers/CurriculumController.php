<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurriculumController extends Controller
{
    public function index(): View
    {
        $curriculums = Curriculum::with('studyProgram')->latest()->paginate(10);
        return view('admin-prodi.curriculums.index', compact('curriculums'));
    }

    public function create(): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-prodi.curriculums.create', compact('studyPrograms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'study_program_id' => 'required|exists:study_programs,id',
            'year' => 'required|integer|min:2000|max:2100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Curriculum::create($validated);

        return redirect()->route('curriculums.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function edit(Curriculum $curriculum): View
    {
        $studyPrograms = StudyProgram::all();
        return view('admin-prodi.curriculums.edit', compact('curriculum', 'studyPrograms'));
    }

    public function update(Request $request, Curriculum $curriculum): RedirectResponse
    {
        $validated = $request->validate([
            'study_program_id' => 'required|exists:study_programs,id',
            'year' => 'required|integer|min:2000|max:2100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $curriculum->update($validated);

        return redirect()->route('curriculums.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    public function destroy(Curriculum $curriculum): RedirectResponse
    {
        $curriculum->delete();
        return redirect()->route('curriculums.index')->with('success', 'Kurikulum berhasil dihapus.');
    }
}
