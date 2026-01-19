<x-app-layout>
    <x-slot name="header">Nilai</x-slot>
    <x-slot name="title">Nilai</x-slot>

    @forelse($dkbsList as $dkbs)
        <x-card class="mb-6" title="Semester {{ $dkbs->semester }} - {{ $dkbs->academic_year }}">
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SKS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">UTS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">UAS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nilai Akhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Huruf</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($dkbs->details as $detail)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $detail->schedule->course->code }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->course->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->course->sks }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->grade?->tugas ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->grade?->uts ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->grade?->uas ?? '-' }}</td>
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
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </x-card>
    @empty
        <x-card>
            <p class="text-gray-500">Belum ada nilai.</p>
        </x-card>
    @endforelse
</x-app-layout>
