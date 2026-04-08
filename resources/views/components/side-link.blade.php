@props(['active'])

@php
$classes = ($active ?? false)
    ? '
        flex items-center p-4
        bg-blue-500 text-white
        dark:bg-gray-900 dark:text-white
        transition duration-150 ease-in-out
      '
    : '
        flex items-center p-4
        text-gray-500
        hover:bg-gray-200 hover:text-blue-600
        dark:text-gray-400
        dark:hover:bg-gray-700 dark:hover:text-white
        transition duration-150 ease-in-out
      ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
