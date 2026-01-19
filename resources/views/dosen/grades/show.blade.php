<x-app-layout>
    <x-slot name="header">Input Nilai - {{ $schedule->course->name }}</x-slot>
    <x-slot name="title">Input Nilai</x-slot>

    @php
        $allLocked = $students->isNotEmpty() && $students->every(fn($s) => $s->grade?->is_locked);
        $hasUnlocked = $students->contains(fn($s) => !$s->grade?->is_locked);
        $hasGradesToLock = $students->contains(fn($s) => $s->grade?->final_score !== null && !$s->grade?->is_locked);
    @endphp

    <x-card>
        @if($allLocked)
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Nilai Sudah Dikunci</h3>
                        <p class="mt-1 text-sm text-green-700">Semua nilai pada kelas ini sudah dikunci dan tidak dapat diubah lagi.</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('grades.store', $schedule) }}" method="POST">
            @csrf
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">UTS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">UAS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nilai Akhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Huruf</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @forelse($students as $index => $detail)
                        @php $isLocked = $detail->grade?->is_locked; @endphp
                        <tr class="{{ $isLocked ? 'bg-gray-50' : '' }}">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $detail->dkbs->student->nim }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->dkbs->student->user->name }}</td>
                            <td class="px-6 py-4">
                                <input type="hidden" name="grades[{{ $index }}][dkbs_detail_id]" value="{{ $detail->id }}">
                                @if($isLocked)
                                    <span class="text-sm text-gray-600">{{ $detail->grade->tugas ?? '-' }}</span>
                                @else
                                    <x-text-input type="number" name="grades[{{ $index }}][tugas]" class="w-20" min="0" max="100" step="0.01" :value="$detail->grade?->tugas" />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($isLocked)
                                    <span class="text-sm text-gray-600">{{ $detail->grade->uts ?? '-' }}</span>
                                @else
                                    <x-text-input type="number" name="grades[{{ $index }}][uts]" class="w-20" min="0" max="100" step="0.01" :value="$detail->grade?->uts" />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($isLocked)
                                    <span class="text-sm text-gray-600">{{ $detail->grade->uas ?? '-' }}</span>
                                @else
                                    <x-text-input type="number" name="grades[{{ $index }}][uas]" class="w-20" min="0" max="100" step="0.01" :value="$detail->grade?->uas" />
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->grade?->final_score ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                @if($detail->grade?->grade_letter)
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                        {{ $detail->grade->grade_letter === 'A' ? 'bg-green-100 text-green-800' : 
                                           ($detail->grade->grade_letter === 'B' ? 'bg-blue-100 text-blue-800' : 
                                           ($detail->grade->grade_letter === 'C' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($detail->grade->grade_letter === 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                        {{ $detail->grade->grade_letter }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                @if($isLocked)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">
                                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                        Terkunci
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">
                                        Belum dikunci
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada mahasiswa yang mengambil kelas ini.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table>

            @if($students->isNotEmpty())
                <div class="mt-4 flex justify-between items-center border-t pt-4">
                    <x-link-button href="{{ route('grades.index') }}" variant="secondary">Kembali</x-link-button>
                    
                    <div class="flex gap-3">
                        @if($hasUnlocked)
                            <x-button type="submit">Simpan Nilai</x-button>
                        @endif
                        
                        @if($hasGradesToLock)
                            <button type="button" 
                                    onclick="if(confirm('Nilai yang dikunci tidak dapat diubah lagi. Lanjutkan?')) { document.getElementById('lock-form').submit(); }"
                                    class="inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Kunci Nilai (Final)
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </form>

        <form id="lock-form" action="{{ route('grades.lock', $schedule) }}" method="POST" class="hidden">
            @csrf
        </form>
    </x-card>
</x-app-layout>
