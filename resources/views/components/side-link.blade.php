@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center justify-center p-4 dark:bg-gray-900 text-white transition duration-150 ease-in-out'
    : 'flex items-center justify-center p-4 text-gray-400 hover:bg-gray-700 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
