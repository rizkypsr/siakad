<x-app-layout>
    <x-slot name="header">Tambah Program Studi</x-slot>
    <x-slot name="title">Tambah Program Studi</x-slot>

    <x-card>
        <form action="{{ route('study-programs.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="faculty_id" value="Fakultas" />
                <select id="faculty_id" name="faculty_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Fakultas</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="code" value="Kode Prodi" />
                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code')" required />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="name" value="Nama Prodi" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="degree" value="Jenjang" />
                <select id="degree" name="degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach(['D3', 'S1', 'S2', 'S3'] as $degree)
                        <option value="{{ $degree }}" {{ old('degree') == $degree ? 'selected' : '' }}>{{ $degree }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('degree')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('study-programs.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
