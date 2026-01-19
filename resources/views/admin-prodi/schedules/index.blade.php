<x-app-layout>
    <x-slot name="header">Jadwal Kuliah</x-slot>
    <x-slot name="title">Jadwal Kuliah</x-slot>

    <x-card>
        <div class="mb-4 flex justify-end">
            <x-link-button href="{{ route('schedules.create') }}">Tambah Jadwal</x-link-button>
        </div>

        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mata Kuliah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Dosen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hari</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ruang</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($schedules as $schedule)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $schedule->course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->lecturer->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ ucfirst($schedule->day) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $schedule->room }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <a href="{{ route('schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </x-card>
</x-app-layout>
