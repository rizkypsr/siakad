<x-app-layout>
    <x-slot name="header">Edit Fakultas</x-slot>
    <x-slot name="title">Edit Fakultas</x-slot>

    <x-card>
        <form action="{{ route('faculties.update', $faculty) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="code" value="Kode Fakultas" />
                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $faculty->code)" required />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="name" value="Nama Fakultas" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $faculty->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('faculties.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
