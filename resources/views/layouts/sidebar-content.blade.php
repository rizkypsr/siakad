<nav class="flex-1 space-y-1 px-2 py-4">
    <!-- Dashboard - All roles -->
    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
        Dashboard
    </x-sidebar-link>

    @if(auth()->user()->isAdminFakultas())
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-indigo-200">Admin Fakultas</p>
        </div>
        <x-sidebar-link :href="route('faculties.index')" :active="request()->routeIs('faculties.*')" icon="building">
            Fakultas
        </x-sidebar-link>
        <x-sidebar-link :href="route('study-programs.index')" :active="request()->routeIs('study-programs.*')" icon="academic-cap">
            Program Studi
        </x-sidebar-link>
        <x-sidebar-link :href="route('lecturers.index')" :active="request()->routeIs('lecturers.*')" icon="users">
            Dosen
        </x-sidebar-link>
    @endif

    @if(auth()->user()->isAdminProdi())
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-indigo-200">Admin Prodi</p>
        </div>
        <x-sidebar-link :href="route('students.verification.index')" :active="request()->routeIs('students.verification.*')" icon="user-group">
            Verifikasi Mahasiswa
        </x-sidebar-link>
        <x-sidebar-link :href="route('curriculums.index')" :active="request()->routeIs('curriculums.*')" icon="document-text">
            Kurikulum
        </x-sidebar-link>
        <x-sidebar-link :href="route('courses.index')" :active="request()->routeIs('courses.*')" icon="book-open">
            Mata Kuliah
        </x-sidebar-link>
        <x-sidebar-link :href="route('schedules.index')" :active="request()->routeIs('schedules.*')" icon="calendar">
            Jadwal Kuliah
        </x-sidebar-link>
        <x-sidebar-link :href="route('students.index')" :active="request()->routeIs('students.*') && !request()->routeIs('students.verification.*')" icon="users">
            Mahasiswa
        </x-sidebar-link>
        <x-sidebar-link :href="route('dkbs.approval')" :active="request()->routeIs('dkbs.approval')" icon="clipboard-check">
            Approval DKBS
        </x-sidebar-link>
    @endif

    @if(auth()->user()->isDosen())
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-indigo-200">Dosen</p>
        </div>
        <x-sidebar-link :href="route('lecturer.schedules')" :active="request()->routeIs('lecturer.schedules')" icon="calendar">
            Jadwal Mengajar
        </x-sidebar-link>
        <x-sidebar-link :href="route('grades.index')" :active="request()->routeIs('grades.*')" icon="clipboard-list">
            Input Nilai
        </x-sidebar-link>
    @endif

    @if(auth()->user()->isMahasiswa() && auth()->user()->student?->isApproved())
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-indigo-200">Mahasiswa</p>
        </div>
        <x-sidebar-link :href="route('dkbs.index')" :active="request()->routeIs('dkbs.*')" icon="clipboard-document-list">
            DKBS
        </x-sidebar-link>
        <x-sidebar-link :href="route('student.schedule')" :active="request()->routeIs('student.schedule')" icon="calendar">
            Jadwal Kuliah
        </x-sidebar-link>
        <x-sidebar-link :href="route('student.grades')" :active="request()->routeIs('student.grades')" icon="chart-bar">
            Nilai
        </x-sidebar-link>
        <x-sidebar-link :href="route('student.transcript')" :active="request()->routeIs('student.transcript')" icon="document">
            Transkrip
        </x-sidebar-link>
    @endif
</nav>

<!-- User info at bottom -->
<div class="border-t border-indigo-800 p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
            <p class="text-xs text-indigo-200">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
        </div>
    </div>
</div>
