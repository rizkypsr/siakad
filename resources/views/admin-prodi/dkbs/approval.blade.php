<x-app-layout>
    <x-slot name="header">Approval DKBS</x-slot>
    <x-slot name="title">Approval DKBS</x-slot>

    <x-card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tahun Akademik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total SKS</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($dkbsList as $dkbs)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $dkbs->student->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->student->nim }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->academic_year }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->semester }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $dkbs->details->sum(fn($d) => $d->schedule->course->sks ?? 0) }} SKS</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm space-x-2">
                            <form action="{{ route('dkbs.approve', $dkbs) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                            </form>
                            <form action="{{ route('dkbs.reject', $dkbs) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada DKBS yang perlu disetujui.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $dkbsList->links() }}
        </div>
    </x-card>
</x-app-layout>
