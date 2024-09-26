<div class="sticky top-0 left-0 z-30 flex items-center px-6 py-2 bg-white shadow-md shadow-black/5">

    <button type="button" class="text-lg text-gray-600 sidebar-toggle" wire:click="toggleSidebar">
        <x-icons.menu />
    </button>

    <!-- Breadcrumb -->
    <ol class="inline-flex items-center ml-4 space-x-1 text-sm md:space-x-2 rtl:space-x-reverse">
        @isset($bradcrumb[0])
            <li class="inline-flex items-center">
                <span
                    class="inline-flex items-center text-sm font-medium text-gray-400 dark:text-gray-400 {{ $bradcrumb[1] ?? 'text-gray-500' }}">
                    {{ $bradcrumb[0] }}
                </span>
            </li>
        @endisset

        @isset($bradcrumb[1])
            <li>
                <div class="flex items-center">
                    <svg class="block w-3 h-3 mx-1 text-gray-400 rtl:rotate-180 " aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="text-sm font-medium text-gray-400 ms-1 md:ms-2 dark:text-gray-400 {{ $bradcrumb[2] ?? 'text-gray-500' }}">{{ $bradcrumb[1] }}</span>
                </div>
            </li>
        @endisset

        @isset($bradcrumb[2])
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span
                        class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">{{ $bradcrumb[2] }}</span>
                </div>
            </li>
        @endisset

    </ol>

    <ul class="flex items-center ml-auto">

        <li class="ml-3 dropdown">
            <button type="button" class="flex items-center dropdown-toggle ">
                <span class="mr-3 font-medium text-gray-400">
                    {{ Auth::user()->name ?? 'Usuario Logado' }}
                </span>
            </button>

        </li>

        <li class="mr-1 dropdown">
            <button type="button" title="Sair" wire:click="logout"
                class="flex items-center justify-center w-4 h-4 mx-2 text-gray-400 rounded dropdown-toggle hover:bg-gray-50 hover:text-gray-600">
                <x-icons.logout />
            </button>
            <div
                class="z-30 hidden w-full max-w-xs bg-white border border-gray-100 rounded-md shadow-md dropdown-menu shadow-black/5">
            </div>
        </li>

        <li class="dropdown" title="Tema">
            <x-ui-theme-switch only-icons />
        </li>
    </ul>
</div>
