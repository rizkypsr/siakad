<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="text-xl font-semibold text-gray-900">
                Selamat datang, {{ $user->name }}!
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Role: {{ ucfirst(str_replace('_', ' ', $user->role)) }}
            </p>
        </div>

        @if($user->isAdminFakultas())
            <!-- Admin Fakultas Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-indigo-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Fakultas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['faculties'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-green-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7l9-5-9-5-9 5 9 5z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Program Studi</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['study_programs'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-yellow-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Dosen</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['lecturers'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-blue-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Mahasiswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['students'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($user->isAdminProdi())
            <!-- Admin Prodi Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-indigo-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Mata Kuliah</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['courses'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-green-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Jadwal</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['schedules'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-blue-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Mahasiswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['students'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-orange-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">DKBS Pending</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_dkbs'] }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('students.verification.index') }}" class="rounded-lg bg-white p-5 shadow hover:bg-yellow-50 transition">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-yellow-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Calon Mahasiswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_students'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if($user->isDosen())
            <!-- Dosen Schedule -->
            <div class="rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Jadwal Mengajar</h3>
                </div>
                <div class="p-6">
                    @if($schedules->isEmpty())
                        <p class="text-gray-500">Belum ada jadwal mengajar.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hari</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ruang</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $schedule->course->name }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ ucfirst($schedule->day) }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->room }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($user->isMahasiswa())
            <!-- Mahasiswa Info -->
            @if($student)
                @if($student->isPending())
                    <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Menunggu Verifikasi</h3>
                                <p class="mt-2 text-sm text-yellow-700">
                                    Pendaftaran Anda sedang dalam proses verifikasi oleh Admin. NIM akan diberikan setelah pendaftaran disetujui.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($student->isRejected())
                    <div class="rounded-lg bg-red-50 border border-red-200 p-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Pendaftaran Ditolak</h3>
                                <p class="mt-2 text-sm text-red-700">
                                    Maaf, pendaftaran Anda ditolak. Silakan hubungi Admin untuk informasi lebih lanjut.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Mahasiswa</h3>
                        <dl class="mt-4 space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">NIM</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $student->nim }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Program Studi</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $student->studyProgram->name ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Angkatan</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $student->year_of_entry }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Status</dt>
                                <dd class="text-sm font-medium">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $student->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h3 class="text-lg font-medium text-gray-900">Status DKBS</h3>
                        @if($current_dkbs)
                            <dl class="mt-4 space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Tahun Akademik</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $current_dkbs->academic_year }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Semester</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $current_dkbs->semester }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Status</dt>
                                    <dd class="text-sm font-medium">
                                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                            {{ $current_dkbs->status === 'approved' ? 'bg-green-100 text-green-800' : ($current_dkbs->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($current_dkbs->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                            <div class="mt-4">
                                <a href="{{ route('dkbs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Lihat DKBS →
                                </a>
                            </div>
                        @else
                            <p class="mt-4 text-sm text-gray-500">Belum ada DKBS aktif.</p>
                            <div class="mt-4">
                                <a href="{{ route('dkbs.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Buat DKBS Baru →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            @else
                <div class="rounded-lg bg-yellow-50 p-6">
                    <p class="text-yellow-700">Data mahasiswa belum lengkap. Hubungi administrator.</p>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
