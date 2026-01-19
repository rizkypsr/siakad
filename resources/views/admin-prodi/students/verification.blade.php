<x-app-layout>
    <x-slot name="header">Verifikasi Calon Mahasiswa</x-slot>
    <x-slot name="title">Verifikasi Calon Mahasiswa</x-slot>

    <x-card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Program Studi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tanggal Daftar</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @forelse($pendingStudents as $student)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $student->user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $student->user->email }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $student->studyProgram->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $student->created_at->format('d/m/Y H:i') }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('students.verification.show', $student) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            <form action="{{ route('students.verification.approve', $student) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Setujui pendaftaran ini?')">Approve</button>
                            </form>
                            <form action="{{ route('students.verification.reject', $student) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tolak pendaftaran ini?')">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada calon mahasiswa yang perlu diverifikasi.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $pendingStudents->links() }}
        </div>
    </x-card>
</x-app-layout>
