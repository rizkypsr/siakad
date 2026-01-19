<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-indigo-600">SIAKAD</h1>
        <p class="mt-1 text-sm text-gray-600">Registrasi Calon Mahasiswa Baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="study_program_id" value="Program Studi" />
            <select id="study_program_id" name="study_program_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Pilih Program Studi</option>
                @foreach($studyPrograms as $prodi)
                    <option value="{{ $prodi->id }}" {{ old('study_program_id') == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->faculty->name }} - {{ $prodi->name }} ({{ $prodi->degree }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('study_program_id')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="birth_place" value="Tempat Lahir" />
                <x-text-input id="birth_place" class="block mt-1 w-full" type="text" name="birth_place" :value="old('birth_place')" required />
                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="birth_date" value="Tanggal Lahir" />
                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="gender" value="Jenis Kelamin" />
                <select id="gender" name="gender" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" value="No. HP" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="address" value="Alamat" />
            <textarea id="address" name="address" rows="2" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                Sudah punya akun?
            </a>
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
