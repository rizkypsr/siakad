@props(['variant' => 'primary'])

@php
$classes = match($variant) {
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
    'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-indigo-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
    default => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
};
@endphp

<button {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 $classes"]) }}>
    {{ $slot }}
</button>
