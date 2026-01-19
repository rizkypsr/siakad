<x-app-layout>
    <x-slot name="header">Edit DKBS</x-slot>
    <x-slot name="title">Edit DKBS</x-slot>

    <x-card>
        <form action="{{ route('dkbs.update', $dkbs) }}" method="POST" class="space-y-6" x-data="dkbsForm()">
            @csrf
            @method('PUT')

            <!-- Info Semester (Read Only) -->
            <div class="rounded-lg bg-indigo-50 p-4">
                <h3 class="text-sm font-medium text-indigo-800">Informasi Semester</h3>
                <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-indigo-600">Tahun Akademik:</span>
                        <span class="ml-1 font-medium text-indigo-900">{{ $dkbs->academic_year }}</span>
                    </div>
                    <div>
                        <span class="text-indigo-600">Semester:</span>
                        <span class="ml-1 font-medium text-indigo-900">{{ $dkbs->semester }}</span>
                    </div>
                </div>
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
                        @php $isSelected = in_array($schedule->id, old('schedule_ids', $selectedIds)); @endphp
                        <label class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded border cursor-pointer transition"
                               :class="{ 'bg-indigo-50 border-indigo-300': isSelected({{ $schedule->id }}) }">
                            <input type="checkbox" 
                                   name="schedule_ids[]" 
                                   value="{{ $schedule->id }}" 
                                   class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                   data-sks="{{ $schedule->course->sks }}"
                                   @change="toggleCourse($event, {{ $schedule->course->sks }})"
                                   {{ $isSelected ? 'checked' : '' }}>
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
                                    {{ ucfirst($schedule->day) }}, {{ substr($schedule->start_time, 0, 5) }}-{{ substr($schedule->end_time, 0, 5) }} | 
                                    {{ $schedule->room }} | 
                                    {{ $schedule->lecturer->user->name }}
                                </p>
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Tidak ada jadwal tersedia.</p>
                    @endforelse
                </div>
                <x-input-error :messages="$errors->get('schedule_ids')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-link-button href="{{ route('dkbs.show', $dkbs) }}" variant="secondary">Batal</x-link-button>
                <x-button type="submit" x-bind:disabled="totalSks > 24 || totalSks === 0">Simpan Perubahan</x-button>
            </div>
        </form>
    </x-card>

    <script>
        function dkbsForm() {
            return {
                totalSks: 0,
                selectedIds: @json($selectedIds),
                init() {
                    document.querySelectorAll('input[name="schedule_ids[]"]:checked').forEach(cb => {
                        this.totalSks += parseInt(cb.dataset.sks);
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
