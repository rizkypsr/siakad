<x-app-layout>
    <x-slot name="header">Edit Kurikulum</x-slot>
    <x-slot name="title">Edit Kurikulum</x-slot>

    <x-card>
        <form action="{{ route('curriculums.update', $curriculum) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="study_program_id" value="Program Studi" />
                <select id="study_program_id" name="study_program_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Prodi</option>
                    @foreach($studyPrograms as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('study_program_id', $curriculum->study_program_id) == $prodi->id ? 'selected' : '' }}>{{ $prodi->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('study_program_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="year" value="Tahun Kurikulum" />
                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year', $curriculum->year)" min="2000" max="2100" required />
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
            </div>

            <div class="flex items-center">
                <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $curriculum->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('curriculums.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
