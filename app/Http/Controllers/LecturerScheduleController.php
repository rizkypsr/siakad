<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\View\View;

class LecturerScheduleController extends Controller
{
    public function index(): View
    {
        $lecturer = auth()->user()->lecturer;
        
        $schedules = $lecturer 
            ? Schedule::where('lecturer_id', $lecturer->id)
                ->with('course')
                ->orderByRaw("FIELD(day, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
                ->orderBy('start_time')
                ->get()
            : collect();

        return view('dosen.schedules.index', compact('schedules'));
    }
}
