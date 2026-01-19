<?php

namespace App\Http\Controllers;

use App\Models\Dkbs;
use Illuminate\View\View;

class StudentGradeController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()->student;
        $dkbsList = Dkbs::where('student_id', $student->id)
            ->where('status', 'approved')
            ->with(['details.schedule.course', 'details.grade'])
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('mahasiswa.grades.index', compact('dkbsList'));
    }
}
