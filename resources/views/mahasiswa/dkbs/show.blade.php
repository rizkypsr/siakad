<x-app-layout>
    <x-slot name="header">Detail DKBS</x-slot>
    <x-slot name="title">Detail DKBS</x-slot>

    <x-card>
        <!-- Header Info -->
        <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4 rounded-lg bg-gray-50 p-4">
            <div>
                <p class="text-sm text-gray-500">Tahun Akademik</p>
                <p class="font-medium text-gray-900">{{ $dkbs->academic_year }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Semester</p>
                <p class="font-medium text-gray-900">{{ $dkbs->semester }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total SKS</p>
                <p class="font-medium text-gray-900">{{ $totalSks }} SKS</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                    {{ $dkbs->status === 'approved' ? 'bg-green-100 text-green-800' : 
                       ($dkbs->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($dkbs->status) }}
                </span>
            </div>
        </div>

        <!-- Course List -->
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SKS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jadwal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ruang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Dosen</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($dkbs->details as $detail)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $detail->schedule->course->code }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->course->sks }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ ucfirst($detail->schedule->day) }}, {{ substr($detail->schedule->start_time, 0, 5) }}-{{ substr($detail->schedule->end_time, 0, 5) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->room }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $detail->schedule->lecturer->user->name }}</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="2" class="px-6 py-4 text-sm font-medium text-gray-900">Total</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $totalSks }} SKS</td>
                    <td colspan="3"></td>
                </tr>
            </x-slot>
        </x-table>

        <!-- Actions -->
        <div class="mt-6 flex justify-between border-t pt-4">
            <x-link-button href="{{ route('dkbs.index') }}" variant="secondary">Kembali</x-link-button>
            
            <div class="flex gap-3">
                @if($dkbs->status === 'draft')
                    <x-link-button href="{{ route('dkbs.edit', $dkbs) }}" variant="secondary">Edit</x-link-button>
                    
                    <form action="{{ route('dkbs.destroy', $dkbs) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" variant="danger" onclick="return confirm('Hapus DKBS ini?')">Hapus</x-button>
                    </form>
                    
                    <form action="{{ route('dkbs.submit', $dkbs) }}" method="POST" class="inline">
                        @csrf
                        <x-button type="submit" variant="success" onclick="return confirm('Submit DKBS untuk disetujui?')">Submit DKBS</x-button>
                    </form>
                @endif
            </div>
        </div>
    </x-card>
</x-app-layout>
