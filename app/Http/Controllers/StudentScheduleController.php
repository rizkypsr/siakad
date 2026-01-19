<?php

namespace App\Http\Controllers;

use App\Models\Dkbs;
use Illuminate\View\View;

class StudentScheduleController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()->student;
        $dkbs = Dkbs::where('student_id', $student->id)
            ->where('status', 'approved')
            ->latest()
            ->first();

        $schedules = collect();

        if ($dkbs) {
            $schedules = $dkbs->details()
                ->with(['schedule.course', 'schedule.lecturer.user'])
                ->get()
                ->pluck('schedule')
                ->sortBy([
                    fn($a, $b) => array_search($a->day, ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']) <=> array_search($b->day, ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']),
                    fn($a, $b) => $a->start_time <=> $b->start_time,
                ]);
        }

        return view('mahasiswa.schedules.index', compact('schedules', 'dkbs'));
    }
}
