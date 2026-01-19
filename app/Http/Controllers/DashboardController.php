<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Dkbs;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudyProgram;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $data = ['user' => $user];

        if ($user->isAdminFakultas()) {
            $data['stats'] = [
                'faculties' => Faculty::count(),
                'study_programs' => StudyProgram::count(),
                'lecturers' => Lecturer::count(),
                'students' => Student::count(),
            ];
        } elseif ($user->isAdminProdi()) {
            $data['stats'] = [
                'courses' => Course::count(),
                'schedules' => Schedule::count(),
                'students' => Student::where('registration_status', 'approved')->count(),
                'pending_dkbs' => Dkbs::where('status', 'submitted')->count(),
                'pending_students' => Student::where('registration_status', 'pending')->count(),
            ];
        } elseif ($user->isDosen()) {
            $lecturer = $user->lecturer;
            $data['schedules'] = $lecturer ? Schedule::where('lecturer_id', $lecturer->id)
                ->with('course')
                ->get() : collect();
        } elseif ($user->isMahasiswa()) {
            $student = $user->student;
            $data['student'] = $student;
            $data['current_dkbs'] = $student ? Dkbs::where('student_id', $student->id)
                ->latest()
                ->first() : null;
        }

        return view('dashboard', $data);
    }
}
