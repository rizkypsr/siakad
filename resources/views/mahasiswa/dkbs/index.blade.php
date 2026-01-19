<x-app-layout>
    <x-slot name="header">DKBS</x-slot>
    <x-slot name="title">DKBS</x-slot>

    <x-card>
        <div class="mb-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Daftar Kartu Rencana Studi</p>
            </div>
            <x-link-button href="{{ route('dkbs.create') }}">Buat DKBS Baru</x-link-button>
        </div>

        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tahun Akademik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah MK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total SKS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($dkbsList as $dkbs)
                    @php
                        $totalSks = $dkbs->details->sum(fn($d) => $d->schedule->course->sks ?? 0);
                    @endphp
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $dkbs->academic_year }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->semester }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->details->count() }} MK</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $totalSks }} SKS</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                {{ $dkbs->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($dkbs->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($dkbs->status) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('dkbs.show', $dkbs) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            @if($dkbs->status === 'draft')
                                <a href="{{ route('dkbs.edit', $dkbs) }}" class="text-gray-600 hover:text-gray-900">Edit</a>
                                <form action="{{ route('dkbs.submit', $dkbs) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">Submit</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada DKBS. <a href="{{ route('dkbs.create') }}" class="text-indigo-600 hover:text-indigo-500">Buat DKBS baru</a>
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $dkbsList->links() }}
        </div>
    </x-card>
</x-app-layout>
