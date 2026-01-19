<x-app-layout>
    <x-slot name="header">Detail Calon Mahasiswa</x-slot>
    <x-slot name="title">Detail Calon Mahasiswa</x-slot>

    <x-card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Akun</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->user->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->user->email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Tanggal Daftar</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Pribadi</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Tempat, Tanggal Lahir</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->birth_place }}, {{ $student->birth_date?->format('d F Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">No. HP</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->phone }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Alamat</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->address }}</dd>
                    </div>
                </dl>
            </div>

            <div class="space-y-4 md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Akademik</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Fakultas</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->studyProgram->faculty->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Program Studi</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->studyProgram->name }} ({{ $student->studyProgram->degree }})</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Tahun Masuk</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $student->year_of_entry }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3 border-t pt-4">
            <x-link-button href="{{ route('students.verification.index') }}" variant="secondary">Kembali</x-link-button>
            <form action="{{ route('students.verification.reject', $student) }}" method="POST" class="inline">
                @csrf
                <x-button type="submit" variant="danger" onclick="return confirm('Tolak pendaftaran ini?')">Tolak</x-button>
            </form>
            <form action="{{ route('students.verification.approve', $student) }}" method="POST" class="inline">
                @csrf
                <x-button type="submit" variant="success" onclick="return confirm('Setujui pendaftaran ini?')">Approve & Generate NIM</x-button>
            </form>
        </div>
    </x-card>
</x-app-layout>
