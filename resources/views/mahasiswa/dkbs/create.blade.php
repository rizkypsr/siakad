<x-app-layout>
    <x-slot name="header">Buat DKBS</x-slot>
    <x-slot name="title">Buat DKBS</x-slot>

    <x-card>
        <form action="{{ route('dkbs.store') }}" method="POST" class="space-y-6" x-data="dkbsForm()">
            @csrf

            <!-- Info Semester (Read Only) -->
            <div class="rounded-lg bg-indigo-50 p-4">
                <h3 class="text-sm font-medium text-indigo-800">Informasi Semester</h3>
                <div class="mt-2 grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-indigo-600">Tahun Akademik:</span>
                        <span class="ml-1 font-medium text-indigo-900">{{ $academicYear }}</span>
                    </div>
                    <div>
                        <span class="text-indigo-600">Semester:</span>
                        <span class="ml-1 font-medium text-indigo-900">{{ $semester }}</span>
                    </div>
                    <div>
                        <span class="text-indigo-600">Tipe:</span>
                        <span class="ml-1 font-medium text-indigo-900">{{ ucfirst($semesterType) }}</span>
                    </div>
                </div>
                <p class="mt-2 text-xs text-indigo-600">* Semester ditentukan otomatis berdasarkan tahun masuk Anda</p>
            </div>

            <!-- SKS Counter -->
            <div class="flex items-center justify-between rounded-lg border p-4" :class="totalSks > 24 ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50'">
                <div>
                    <span class="text-sm text-gray-600">Total SKS Dipilih:</span>
                    <span class="ml-2 text-2xl font-bold" :class="totalSks > 24 ? 'text-red-600' : 'text-gray-900'" x-text="totalSks"></span>
                    <span class="text-sm text-gray-500">/ 24 SKS</span>
                </div>
                <div x-show="totalSks > 24" class="text-sm text-red-600">
                    Melebihi batas maksimal!
                </div>
            </div>

            @if(session('error'))
                <div class="rounded-md bg-red-50 p-4">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Course Selection -->
            <div>
                <x-input-label value="Pilih Mata Kuliah" />
                <p class="text-sm text-gray-500 mb-3">Centang mata kuliah yang ingin diambil (maksimal 24 SKS)</p>
                
                <div class="space-y-2 max-h-[500px] overflow-y-auto border rounded-md p-4">
                    @forelse($schedules as $schedule)
                        <label class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded border cursor-pointer transition"
                               :class="{ 'bg-indigo-50 border-indigo-300': isSelected({{ $schedule->id }}) }">
                            <input type="checkbox" 
                                   name="schedule_ids[]" 
                                   value="{{ $schedule->id }}" 
                                   class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                   data-sks="{{ $schedule->course->sks }}"
                                   @change="toggleCourse($event, {{ $schedule->course->sks }})"
                                   {{ in_array($schedule->id, old('schedule_ids', [])) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $schedule->course->code }} - {{ $schedule->course->name }}
                                    </p>
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                        {{ $schedule->course->sks }} SKS
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ ucfirst($schedule->day) }}, {{ substr($schedule->start_time, 0, 5) }}-{{ substr($schedule->end_time, 0, 5) }}
                                    </span>
                                    <span class="mx-2">|</span>
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $schedule->room }}
                                    </span>
                                    <span class="mx-2">|</span>
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $schedule->lecturer->user->name }}
                                    </span>
                                </p>
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Tidak ada jadwal tersedia untuk semester ini.</p>
                    @endforelse
                </div>
                <x-input-error :messages="$errors->get('schedule_ids')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('dkbs.index') }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit" x-bind:disabled="totalSks > 24 || totalSks === 0">Simpan Draft</x-button>
            </div>
        </form>
    </x-card>

    <script>
        function dkbsForm() {
            return {
                totalSks: 0,
                selectedIds: [],
                init() {
                    document.querySelectorAll('input[name="schedule_ids[]"]:checked').forEach(cb => {
                        this.totalSks += parseInt(cb.dataset.sks);
                        this.selectedIds.push(parseInt(cb.value));
                    });
                },
                toggleCourse(event, sks) {
                    if (event.target.checked) {
                        this.totalSks += sks;
                        this.selectedIds.push(parseInt(event.target.value));
                    } else {
                        this.totalSks -= sks;
                        this.selectedIds = this.selectedIds.filter(id => id !== parseInt(event.target.value));
                    }
                },
                isSelected(id) {
                    return this.selectedIds.includes(id);
                }
            }
        }
    </script>
</x-app-layout>
