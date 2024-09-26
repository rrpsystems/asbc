<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RRP Tarifador') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <tallstackui:script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (min-width: 768px) {
            .main.active {
                margin-left: 0px;
                width: 100%;
            }
        }
    </style>

</head>

<body class="antialiased text-gray-800 font-inter" x-data="tallstackui_darkTheme()"
    x-bind:class="{ 'dark bg-gray-700': darkTheme, 'bg-white': !darkTheme }">
    <x-ui-toast />
    {{-- <x-ui-dialog /> --}}
    <livewire:template.sidebar />

    <main x-data="{ sideToggle: true }"
        x-on:toggle-sidebar.window="
    let toggleValue = $event.detail[0] !== undefined ? $event.detail[0] : $event.detail;
    sideToggle = toggleValue;
"
        class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 dark:bg-gray-800 min-h-screen transition-all main"
        :class="{ 'active': !sideToggle }">

        <livewire:template.navbar />

        <div class="p-3 ">
            {{ $slot }}
        </div>

    </main>

</body>

</html>
