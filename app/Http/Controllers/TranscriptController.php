<?php

namespace App\Http\Controllers;

use App\Models\Dkbs;
use App\Models\Transcript;
use Illuminate\View\View;

class TranscriptController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()->student;
        $transcripts = Transcript::where('student_id', $student->id)
            ->orderBy('semester')
            ->get();

        $dkbsList = Dkbs::where('student_id', $student->id)
            ->where('status', 'approved')
            ->with(['details.schedule.course', 'details.grade'])
            ->orderBy('semester')
            ->get();

        // Calculate cumulative GPA
        $totalPoints = 0;
        $totalSks = 0;

        foreach ($dkbsList as $dkbs) {
            foreach ($dkbs->details as $detail) {
                if ($detail->grade && $detail->grade->final_score !== null) {
                    $sks = $detail->schedule->course->sks;
                    $totalPoints += $detail->grade->getGradePoint() * $sks;
                    $totalSks += $sks;
                }
            }
        }

        $ipk = $totalSks > 0 ? round($totalPoints / $totalSks, 2) : 0;

        return view('mahasiswa.transcript.index', compact('dkbsList', 'transcripts', 'ipk', 'totalSks'));
    }

    public function downloadPdf()
    {
        // PDF generation would require a package like dompdf
        // For now, return a simple response
        return back()->with('error', 'Fitur download PDF belum tersedia.');
    }
}
