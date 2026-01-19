<x-app-layout>
    <x-slot name="header">Tambah Mahasiswa</x-slot>
    <x-slot name="title">Tambah Mahasiswa</x-slot>

    <x-card>
        <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
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
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nim" value="NIM" />
                    <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim')" required />
                    <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="year_of_entry" value="Tahun Masuk" />
                    <x-text-input id="year_of_entry" name="year_of_entry" type="number" class="mt-1 block w-full" :value="old('year_of_entry', date('Y'))" min="2000" max="2100" required />
                    <x-input-error :messages="$errors->get('year_of_entry')" class="mt-2" />
                </div>
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
                <x-link-button href="{{ route('students.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
