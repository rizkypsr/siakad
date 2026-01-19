<x-app-layout>
    <x-slot name="header">Mata Kuliah</x-slot>
    <x-slot name="title">Mata Kuliah</x-slot>

    <x-card>
        <div class="mb-4 flex justify-end">
            <x-link-button href="{{ route('courses.create') }}">Tambah Mata Kuliah</x-link-button>
        </div>

        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SKS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prasyarat</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($courses as $course)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $course->code }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $course->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $course->sks }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $course->semester }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $course->prerequisite?->name ?? '-' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <a href="{{ route('courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline ml-2">
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
            {{ $courses->links() }}
        </div>
    </x-card>
</x-app-layout>
