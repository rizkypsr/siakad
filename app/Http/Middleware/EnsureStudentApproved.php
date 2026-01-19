<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isMahasiswa()) {
            $student = $user->student;
            
            if (!$student || !$student->isApproved()) {
                return redirect()->route('dashboard')
                    ->with('error', 'Akun Anda belum diverifikasi. Silakan tunggu proses verifikasi.');
            }
        }

        return $next($request);
    }
}
