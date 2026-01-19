<x-app-layout>
    <x-slot name="header">Transkrip Nilai</x-slot>
    <x-slot name="title">Transkrip Nilai</x-slot>

    <x-card>
        <div class="mb-6 grid grid-cols-2 gap-4 rounded-lg bg-indigo-50 p-4">
            <div>
                <p class="text-sm text-indigo-600">Total SKS</p>
                <p class="text-2xl font-bold text-indigo-900">{{ $totalSks }}</p>
            </div>
            <div>
                <p class="text-sm text-indigo-600">IPK</p>
                <p class="text-2xl font-bold text-indigo-900">{{ number_format($ipk, 2) }}</p>
            </div>
        </div>

        @forelse($dkbsList as $dkbs)
            <div class="mb-6">
                <h3 class="mb-3 text-lg font-medium text-gray-900">Semester {{ $dkbs->semester }} - {{ $dkbs->academic_year }}</h3>
                <x-table>
                    <x-slot name="head">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SKS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Bobot</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        @php
                            $semesterPoints = 0;
                            $semesterSks = 0;
                        @endphp
                        @foreach($dkbs->details as $detail)
                            @php
                                $sks = $detail->schedule->course->sks;
                                $gradePoint = $detail->grade?->getGradePoint() ?? 0;
                                $semesterPoints += $gradePoint * $sks;
                                $semesterSks += $sks;
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $detail->schedule->course->code }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->course->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $sks }}</td>
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
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ number_format($gradePoint, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td colspan="2" class="px-6 py-4 text-sm font-medium text-gray-900">IP Semester</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $semesterSks }}</td>
                            <td colspan="2" class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $semesterSks > 0 ? number_format($semesterPoints / $semesterSks, 2) : '0.00' }}
                            </td>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        @empty
            <p class="text-gray-500">Belum ada transkrip.</p>
        @endforelse
    </x-card>
</x-app-layout>
