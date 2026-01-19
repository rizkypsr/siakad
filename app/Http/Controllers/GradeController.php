<?php

namespace App\Http\Controllers;

use App\Models\DkbsDetail;
use App\Models\Grade;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeController extends Controller
{
    public function index(): View
    {
        $lecturer = auth()->user()->lecturer;
        
        $schedules = $lecturer
            ? Schedule::where('lecturer_id', $lecturer->id)
                ->with('course')
                ->get()
            : collect();

        return view('dosen.grades.index', compact('schedules'));
    }

    public function show(Schedule $schedule): View
    {
        $students = DkbsDetail::where('schedule_id', $schedule->id)
            ->whereHas('dkbs', fn($q) => $q->where('status', 'approved'))
            ->with(['dkbs.student.user', 'grade'])
            ->get();

        return view('dosen.grades.show', compact('schedule', 'students'));
    }

    public function store(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.dkbs_detail_id' => 'required|exists:dkbs_details,id',
            'grades.*.tugas' => 'nullable|numeric|min:0|max:100',
            'grades.*.uts' => 'nullable|numeric|min:0|max:100',
            'grades.*.uas' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            $grade = Grade::firstOrNew(['dkbs_detail_id' => $gradeData['dkbs_detail_id']]);

            if ($grade->is_locked) {
                continue;
            }

            $grade->tugas = $gradeData['tugas'];
            $grade->uts = $gradeData['uts'];
            $grade->uas = $gradeData['uas'];

            if ($grade->tugas !== null && $grade->uts !== null && $grade->uas !== null) {
                $grade->final_score = $grade->calculateFinalScore();
                $grade->grade_letter = $grade->calculateGradeLetter();
            }

            $grade->save();
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function lock(Schedule $schedule): RedirectResponse
    {
        $dkbsDetailIds = DkbsDetail::where('schedule_id', $schedule->id)->pluck('id');

        Grade::whereIn('dkbs_detail_id', $dkbsDetailIds)
            ->whereNotNull('final_score')
            ->update(['is_locked' => true]);

        return back()->with('success', 'Nilai berhasil dikunci.');
    }
}
