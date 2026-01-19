<x-app-layout>
    <x-slot name="header">Jadwal Kuliah</x-slot>
    <x-slot name="title">Jadwal Kuliah</x-slot>

    <x-card>
        @if($dkbs)
            <div class="mb-4">
                <p class="text-sm text-gray-500">Tahun Akademik: {{ $dkbs->academic_year }} | Semester: {{ $dkbs->semester }}</p>
            </div>

            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SKS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ruang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Dosen</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @forelse($schedules as $schedule)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ ucfirst($schedule->day) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->course->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->course->sks }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->room }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->lecturer->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jadwal.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table>
        @else
            <p class="text-gray-500">Belum ada DKBS yang disetujui.</p>
        @endif
    </x-card>
</x-app-layout>
