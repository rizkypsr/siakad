<x-app-layout>
    <x-slot name="header">Tambah Jadwal</x-slot>
    <x-slot name="title">Tambah Jadwal</x-slot>

    <x-card>
        <form action="{{ route('schedules.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="course_id" value="Mata Kuliah" />
                    <select id="course_id" name="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->code }} - {{ $course->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="lecturer_id" value="Dosen" />
                    <select id="lecturer_id" name="lecturer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Pilih Dosen</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>{{ $lecturer->user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('lecturer_id')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <x-input-label for="day" value="Hari" />
                    <select id="day" name="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Pilih Hari</option>
                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('day')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="start_time" value="Jam Mulai" />
                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" required />
                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="end_time" value="Jam Selesai" />
                    <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time')" required />
                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <x-input-label for="room" value="Ruang" />
                    <x-text-input id="room" name="room" type="text" class="mt-1 block w-full" :value="old('room')" required />
                    <x-input-error :messages="$errors->get('room')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="academic_year" value="Tahun Akademik" />
                    <x-text-input id="academic_year" name="academic_year" type="text" class="mt-1 block w-full" :value="old('academic_year', date('Y').'/'.(date('Y')+1))" placeholder="2024/2025" required />
                    <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="semester_type" value="Semester" />
                    <select id="semester_type" name="semester_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="ganjil" {{ old('semester_type') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('semester_type') == 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    <x-input-error :messages="$errors->get('semester_type')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('schedules.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
