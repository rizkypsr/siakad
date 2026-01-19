<?php

namespace App\Http\Controllers;

use App\Models\Dkbs;
use App\Models\DkbsDetail;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DkbsController extends Controller
{
    private const MAX_SKS = 24;

    public function index(): View
    {
        $student = auth()->user()->student;
        $dkbsList = Dkbs::where('student_id', $student->id)
            ->with('details.schedule.course')
            ->latest()
            ->paginate(10);

        return view('mahasiswa.dkbs.index', compact('dkbsList'));
    }

    public function create(): View
    {
        $student = auth()->user()->student;

        // Check if student can create DKBS
        $errors = $student->canCreateDkbs();
        if (!empty($errors)) {
            return view('mahasiswa.dkbs.cannot-create', ['errors' => $errors]);
        }

        // Get current academic info
        $academicYear = Student::getCurrentAcademicYear();
        $semesterType = Student::getCurrentSemesterType();
        $semester = $student->getCurrentSemester();

        // Get available schedules for current semester type and student's study program
        $schedules = Schedule::with(['course.curriculum', 'lecturer.user'])
            ->where('academic_year', $academicYear)
            ->where('semester_type', $semesterType)
            ->whereHas('course.curriculum', function ($q) use ($student) {
                $q->where('study_program_id', $student->study_program_id)
                    ->where('is_active', true);
            })
            ->get();

        return view('mahasiswa.dkbs.create', compact('schedules', 'academicYear', 'semester', 'semesterType'));
    }

    public function store(Request $request): RedirectResponse
    {
        $student = auth()->user()->student;

        // Validate student can create DKBS
        $errors = $student->canCreateDkbs();
        if (!empty($errors)) {
            return back()->with('error', implode(' ', $errors));
        }

        // Get current academic info (not from user input)
        $academicYear = Student::getCurrentAcademicYear();
        $semester = $student->getCurrentSemester();

        $validated = $request->validate([
            'schedule_ids' => 'required|array|min:1',
            'schedule_ids.*' => 'exists:schedules,id',
        ]);

        // Calculate total SKS
        $schedules = Schedule::with('course')->whereIn('id', $validated['schedule_ids'])->get();
        $totalSks = $schedules->sum(fn($s) => $s->course->sks);

        if ($totalSks > self::MAX_SKS) {
            return back()
                ->withInput()
                ->with('error', "Total SKS melebihi batas maksimal " . self::MAX_SKS . " SKS. Total yang dipilih: {$totalSks} SKS.");
        }

        // Check for schedule conflicts
        $conflict = $this->checkScheduleConflict($schedules);
        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', $conflict);
        }

        $dkbs = Dkbs::create([
            'student_id' => $student->id,
            'academic_year' => $academicYear,
            'semester' => $semester,
            'status' => 'draft',
        ]);

        foreach ($validated['schedule_ids'] as $scheduleId) {
            DkbsDetail::create([
                'dkbs_id' => $dkbs->id,
                'schedule_id' => $scheduleId,
            ]);
        }

        return redirect()->route('dkbs.index')->with('success', 'DKBS berhasil dibuat.');
    }

    public function show(Dkbs $dkbs): View
    {
        $this->authorizeStudent($dkbs);
        $dkbs->load('details.schedule.course', 'details.schedule.lecturer.user');
        
        $totalSks = $dkbs->details->sum(fn($d) => $d->schedule->course->sks ?? 0);
        
        return view('mahasiswa.dkbs.show', compact('dkbs', 'totalSks'));
    }

    public function edit(Dkbs $dkbs): View
    {
        $this->authorizeStudent($dkbs);

        if ($dkbs->status !== 'draft') {
            abort(403, 'DKBS tidak dapat diedit.');
        }

        $student = auth()->user()->student;
        $semesterType = Student::getCurrentSemesterType();

        $schedules = Schedule::with(['course.curriculum', 'lecturer.user'])
            ->where('academic_year', $dkbs->academic_year)
            ->where('semester_type', $semesterType)
            ->whereHas('course.curriculum', function ($q) use ($student) {
                $q->where('study_program_id', $student->study_program_id)
                    ->where('is_active', true);
            })
            ->get();

        $selectedIds = $dkbs->details->pluck('schedule_id')->toArray();

        return view('mahasiswa.dkbs.edit', compact('dkbs', 'schedules', 'selectedIds'));
    }

    public function update(Request $request, Dkbs $dkbs): RedirectResponse
    {
        $this->authorizeStudent($dkbs);

        if ($dkbs->status !== 'draft') {
            return back()->with('error', 'DKBS tidak dapat diedit.');
        }

        $validated = $request->validate([
            'schedule_ids' => 'required|array|min:1',
            'schedule_ids.*' => 'exists:schedules,id',
        ]);

        // Calculate total SKS
        $schedules = Schedule::with('course')->whereIn('id', $validated['schedule_ids'])->get();
        $totalSks = $schedules->sum(fn($s) => $s->course->sks);

        if ($totalSks > self::MAX_SKS) {
            return back()
                ->withInput()
                ->with('error', "Total SKS melebihi batas maksimal " . self::MAX_SKS . " SKS. Total yang dipilih: {$totalSks} SKS.");
        }

        // Check for schedule conflicts
        $conflict = $this->checkScheduleConflict($schedules);
        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', $conflict);
        }

        // Delete old details and create new ones
        $dkbs->details()->delete();

        foreach ($validated['schedule_ids'] as $scheduleId) {
            DkbsDetail::create([
                'dkbs_id' => $dkbs->id,
                'schedule_id' => $scheduleId,
            ]);
        }

        return redirect()->route('dkbs.show', $dkbs)->with('success', 'DKBS berhasil diperbarui.');
    }

    public function submit(Dkbs $dkbs): RedirectResponse
    {
        $this->authorizeStudent($dkbs);

        if ($dkbs->status !== 'draft') {
            return back()->with('error', 'DKBS sudah disubmit.');
        }

        // Validate minimum courses
        if ($dkbs->details->isEmpty()) {
            return back()->with('error', 'DKBS harus memiliki minimal 1 mata kuliah.');
        }

        $dkbs->update(['status' => 'submitted']);

        return redirect()->route('dkbs.index')->with('success', 'DKBS berhasil disubmit untuk disetujui.');
    }

    public function destroy(Dkbs $dkbs): RedirectResponse
    {
        $this->authorizeStudent($dkbs);

        if ($dkbs->status !== 'draft') {
            return back()->with('error', 'Hanya DKBS draft yang dapat dihapus.');
        }

        $dkbs->details()->delete();
        $dkbs->delete();

        return redirect()->route('dkbs.index')->with('success', 'DKBS berhasil dihapus.');
    }

    // Admin Prodi methods
    public function approval(): View
    {
        $dkbsList = Dkbs::where('status', 'submitted')
            ->with(['student.user', 'student.studyProgram', 'details.schedule.course'])
            ->latest()
            ->paginate(10);

        return view('admin-prodi.dkbs.approval', compact('dkbsList'));
    }

    public function approve(Dkbs $dkbs): RedirectResponse
    {
        if ($dkbs->status !== 'submitted') {
            return back()->with('error', 'DKBS tidak dalam status submitted.');
        }

        $dkbs->update(['status' => 'approved']);
        return back()->with('success', 'DKBS berhasil disetujui.');
    }

    public function reject(Dkbs $dkbs): RedirectResponse
    {
        if ($dkbs->status !== 'submitted') {
            return back()->with('error', 'DKBS tidak dalam status submitted.');
        }

        $dkbs->update(['status' => 'draft']);
        return back()->with('success', 'DKBS dikembalikan ke draft.');
    }

    private function authorizeStudent(Dkbs $dkbs): void
    {
        if ($dkbs->student_id !== auth()->user()->student->id) {
            abort(403);
        }
    }

    private function checkScheduleConflict($schedules): ?string
    {
        $schedulesByDay = $schedules->groupBy('day');

        foreach ($schedulesByDay as $day => $daySchedules) {
            $sorted = $daySchedules->sortBy('start_time')->values();

            for ($i = 0; $i < count($sorted) - 1; $i++) {
                $current = $sorted[$i];
                $next = $sorted[$i + 1];

                if ($current->end_time > $next->start_time) {
                    return "Jadwal bentrok: {$current->course->name} dan {$next->course->name} pada hari " . ucfirst($day);
                }
            }
        }

        return null;
    }
}
