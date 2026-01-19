<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-indigo-600">SIAKAD</h1>
        <p class="mt-1 text-sm text-gray-600">Sistem Informasi Akademik</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center border-t pt-4">
            <p class="text-sm text-gray-600">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Daftar sebagai Calon Mahasiswa Baru
            </a>
        </div>
    </form>
</x-guest-layout>
