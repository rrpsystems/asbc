<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RRP Tarifador') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <tallstackui:script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Transições suaves para o conteúdo principal */
        .main {
            transition: margin-left 0.2s ease-in-out, width 0.2s ease-in-out;
        }

        /* Quando sidebar está fechado, expandir conteúdo */
        body.sidebar-closed .main {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* Mobile sempre fullwidth */
        @media (max-width: 767px) {
            .main {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>

</head>

<body class="antialiased text-gray-800 font-sans" x-data="tallstackui_darkTheme()"
    x-bind:class="{ 'dark bg-gray-900': darkTheme, 'bg-gray-50': !darkTheme }">
    <x-ui-toast />
    <livewire:template.sidebar />

    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen main">
        <livewire:template.navbar />

        <div class="p-6 md:p-8">
            {{ $slot }}
        </div>

    </main>

</body>

</html>