<x-app-layout>
    <x-slot name="header">Edit Mata Kuliah</x-slot>
    <x-slot name="title">Edit Mata Kuliah</x-slot>

    <x-card>
        <form action="{{ route('courses.update', $course) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="curriculum_id" value="Kurikulum" />
                <select id="curriculum_id" name="curriculum_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Kurikulum</option>
                    @foreach($curriculums as $curriculum)
                        <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $course->curriculum_id) == $curriculum->id ? 'selected' : '' }}>{{ $curriculum->studyProgram->name }} - {{ $curriculum->year }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('curriculum_id')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="code" value="Kode MK" />
                    <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $course->code)" required />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="name" value="Nama MK" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $course->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="sks" value="SKS" />
                    <x-text-input id="sks" name="sks" type="number" class="mt-1 block w-full" :value="old('sks', $course->sks)" min="1" max="6" required />
                    <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="semester" value="Semester" />
                    <x-text-input id="semester" name="semester" type="number" class="mt-1 block w-full" :value="old('semester', $course->semester)" min="1" max="14" required />
                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="prerequisite_course_id" value="Prasyarat (Opsional)" />
                <select id="prerequisite_course_id" name="prerequisite_course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Tidak ada prasyarat</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('prerequisite_course_id', $course->prerequisite_course_id) == $c->id ? 'selected' : '' }}>{{ $c->code }} - {{ $c->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('prerequisite_course_id')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('courses.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
