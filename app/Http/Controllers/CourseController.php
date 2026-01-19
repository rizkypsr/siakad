<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::with(['curriculum.studyProgram', 'prerequisite'])->latest()->paginate(10);
        return view('admin-prodi.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $curriculums = Curriculum::with('studyProgram')->where('is_active', true)->get();
        $courses = Course::all();
        return view('admin-prodi.courses.create', compact('curriculums', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:14',
            'prerequisite_course_id' => 'nullable|exists:courses,id',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function edit(Course $course): View
    {
        $curriculums = Curriculum::with('studyProgram')->where('is_active', true)->get();
        $courses = Course::where('id', '!=', $course->id)->get();
        return view('admin-prodi.courses.edit', compact('course', 'curriculums', 'courses'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:14',
            'prerequisite_course_id' => 'nullable|exists:courses,id',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
