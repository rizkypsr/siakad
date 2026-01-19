<x-app-layout>
    <x-slot name="header">Tambah Dosen</x-slot>
    <x-slot name="title">Tambah Dosen</x-slot>

    <x-card>
        <form action="{{ route('lecturers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="name" value="Nama" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="nidn" value="NIDN" />
                <x-text-input id="nidn" name="nidn" type="text" class="mt-1 block w-full" :value="old('nidn')" required />
                <x-input-error :messages="$errors->get('nidn')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="study_program_id" value="Program Studi" />
                <select id="study_program_id" name="study_program_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Prodi</option>
                    @foreach($studyPrograms as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('study_program_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('study_program_id')" class="mt-2" />
            </div>

            <p class="text-sm text-gray-500">Password default: password</p>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('lecturers.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
