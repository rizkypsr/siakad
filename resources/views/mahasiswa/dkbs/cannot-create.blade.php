<x-app-layout>
    <x-slot name="header">Buat DKBS</x-slot>
    <x-slot name="title">Buat DKBS</x-slot>

    <x-card>
        <div class="text-center py-8">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak Dapat Membuat DKBS</h3>
            <div class="mt-4 space-y-2">
                @foreach($errors as $error)
                    <p class="text-sm text-red-600">• {{ $error }}</p>
                @endforeach
            </div>
            <div class="mt-6">
                <x-link-button href="{{ route('dkbs.index') }}" variant="secondary">Kembali</x-link-button>
            </div>
        </div>
    </x-card>
</x-app-layout>
