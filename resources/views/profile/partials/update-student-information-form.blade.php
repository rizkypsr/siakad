<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Pribadi Mahasiswa
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Lengkapi data pribadi Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.student.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- NIM (Read Only) --}}
            <div>
                <x-input-label for="nim" value="NIM" />
                <x-text-input id="nim" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="$student->nim ?? 'Belum ditetapkan'" disabled />
                <p class="mt-1 text-xs text-gray-500">NIM ditetapkan oleh Admin Prodi</p>
            </div>

            {{-- Program Studi (Read Only) --}}
            <div>
                <x-input-label for="study_program" value="Program Studi" />
                <x-text-input id="study_program" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="$student->studyProgram->name ?? '-'" disabled />
            </div>

            {{-- Tahun Masuk (Read Only) --}}
            <div>
                <x-input-label for="year_of_entry" value="Tahun Masuk" />
                <x-text-input id="year_of_entry" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="$student->year_of_entry" disabled />
            </div>

            {{-- Status (Read Only) --}}
            <div>
                <x-input-label for="status" value="Status" />
                <x-text-input id="status" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="ucfirst($student->status)" disabled />
            </div>
        </div>

        <hr class="my-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- No. Telepon --}}
            <div>
                <x-input-label for="phone" value="No. Telepon" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" 
                    :value="old('phone', $student->phone)" placeholder="08xxxxxxxxxx" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <x-input-label for="gender" value="Jenis Kelamin" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-4">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            {{-- Tempat Lahir --}}
            <div>
                <x-input-label for="birth_place" value="Tempat Lahir" />
                <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" 
                    :value="old('birth_place', $student->birth_place)" placeholder="Kota kelahiran" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <x-input-label for="birth_date" value="Tanggal Lahir" />
                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" 
                    :value="old('birth_date', $student->birth_date?->format('Y-m-d'))" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <x-input-label for="address" value="Alamat Lengkap" />
                <textarea id="address" name="address" rows="3" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                    placeholder="Alamat tempat tinggal saat ini">{{ old('address', $student->address) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'student-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>
