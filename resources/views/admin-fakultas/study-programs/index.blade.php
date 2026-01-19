<x-app-layout>
    <x-slot name="header">Program Studi</x-slot>
    <x-slot name="title">Program Studi</x-slot>

    <x-card>
        <div class="mb-4 flex justify-end">
            <x-link-button href="{{ route('study-programs.create') }}">Tambah Prodi</x-link-button>
        </div>

        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fakultas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jenjang</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($studyPrograms as $prodi)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $prodi->code }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $prodi->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $prodi->faculty->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $prodi->degree }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <a href="{{ route('study-programs.edit', $prodi) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('study-programs.destroy', $prodi) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $studyPrograms->links() }}
        </div>
    </x-card>
</x-app-layout>
