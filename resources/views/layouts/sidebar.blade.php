<!-- Mobile sidebar -->
<div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-300 transform"
     x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
     class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-700 lg:hidden">
    <div class="flex h-16 items-center justify-between px-4">
        <span class="text-xl font-bold text-white">SIAKAD</span>
        <button @click="sidebarOpen = false" class="text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @include('layouts.sidebar-content')
</div>

<!-- Desktop sidebar -->
<div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
    <div class="flex min-h-0 flex-1 flex-col bg-indigo-700">
        <div class="flex h-16 items-center px-4">
            <span class="text-xl font-bold text-white">SIAKAD</span>
        </div>
        @include('layouts.sidebar-content')
    </div>
</div>
