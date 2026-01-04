<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--
    <meta http-equiv="refresh" content="1"> --}}

    <title>{{ config('app.name', 'RRP Tarifador') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <tallstackui:script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

</head>

<body class="font-sans antialiased text-gray-900">
    {{-- <div
        class="flex flex-col items-center w-full min-h-screen pt-6 mb-0 sm:justify-center sm:pt-0 dark:bg-gray-900 ">
        --}}

        {{-- <div>
            <a href="/" wire:navigate>
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </div> --}}

        {{-- <div
            class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            --}}
            {{ $slot }}
            {{--
        </div> --}}
        {{-- </div> --}}
</body>

</html>