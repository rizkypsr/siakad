<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredStudentController extends Controller
{
    public function create(): View
    {
        $studyPrograms = StudyProgram::with('faculty')->get();
        return view('auth.register-student', compact('studyPrograms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'birth_place' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'is_active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'nim' => null,
                'study_program_id' => $request->study_program_id,
                'year_of_entry' => date('Y'),
                'status' => 'aktif',
                'registration_status' => 'pending',
                'phone' => $request->phone,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
            ]);

            event(new Registered($user));

            Auth::login($user);
        });

        return redirect()->route('dashboard');
    }
}
