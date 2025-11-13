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

        <!-- pull tailwindcss from CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <!-- Tailwind Plus Elements for modal dialogs -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Search Modal -->
            <livewire:search-modal />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
                        <div class="relative pb-5 sm:pb-0">
                            <div class="md:flex md:items-center md:justify-between">
                                <div><h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{$header}}</h1></div>
                                @if(isset($actions))
                                    <div>
                                        {{$actions}}
                                    </div>
                                 @endif
                            </div>
                            @isset($tabs)
                                <div>
                                    <x-sub-menu :tabs="$tabs" :active="$active" />
                                </div>
                            @endisset
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
