<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class=" mt-10 font-sans antialiased">
        <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class=" flex flex-1">
                <div class=" max-h-full">
                    @include('layouts.side-bar')
                </div>
                <div class=" flex flex-1 flex-col">
                    @include('layouts.navigation')
                    
                    <!-- Page Heading -->
                    @isset($header)
                    <header class="bg-white dark:bg-gray-900">
                        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                    @endisset
                    
                    <!-- Page Content -->
                    <main>
                        <div class=" max-w-7xl mx-auto py-12">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
