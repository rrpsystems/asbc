@props(['btnCreate' => 'slide-create'])
<div class="inline-flex rounded-md shadow-sm" role="group">
    <button type="button" title="Adicionar um novo ramal" wire:click="$dispatch('{{ $btnCreate }}')"
        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-200 bg-blue-600 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-slate-700 focus:z-10 focus:ring-2 focus:ring-slate-700 focus:text-slate-300 dark:bg-blue-600 dark:border-gray-200 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-slate-500 dark:focus:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="mr-1 lucide lucide-plus">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
        Novo
    </button>

    {{-- <x-ui-input icon="users" wire:model.live='search' />

    <button type="button" title="Filtros"
        class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-200 bg-gray-600 border-t border-b border-r border-gray-200 hover:bg-gray-100 hover:text-slate-700 focus:z-10 focus:ring-2 focus:ring-slate-700 focus:text-slate-300 dark:bg-gray-600 dark:border-gray-200 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-slate-500 dark:focus:text-white">
        <x-icons.filter class="text-lg" h=20 w=20 />

    </button> --}}

    <form class="flex items-center max-w-lg mx-auto">
        <div class="relative w-full ">
            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search"
                class="ps-10 py-2.5 text-sm font-medium text-gray-600 bg-gray-50 border-t border-b border-r border-gray-200  hover:bg-gray-100 hover:text-slate-700 focus:z-10 focus:ring-2 focus:ring-slate-700 focus:text-slate-500 dark:bg-gray-600 dark:border-gray-200 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-slate-500 dark:focus:text-white"
                placeholder="Ramal, Nome, Email" wire:model.live.debounce.500ms='search' />
        </div>
    </form>
    <button type="button" title="Salvar Excel"
        class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-200 bg-green-600 border-t border-b border-gray-200 hover:bg-green-100 hover:text-slate-700 focus:z-10 focus:ring-2 focus:ring-slate-700 focus:text-slate-300 dark:bg-green-700 dark:border-gray-200 dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:ring-slate-500 dark:focus:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-sheet">
            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
            <line x1="3" x2="21" y1="9" y2="9" />
            <line x1="3" x2="21" y1="15" y2="15" />
            <line x1="9" x2="9" y1="9" y2="21" />
            <line x1="15" x2="15" y1="9" y2="21" />
        </svg>
    </button>
    <button type="button" title="Salvar PDF"
        class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-200 bg-red-600 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-slate-700 focus:z-10 focus:ring-2 focus:ring-slate-700 focus:text-slate-300 dark:bg-red-700 dark:border-gray-200 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-slate-500 dark:focus:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-file-text">
            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
            <path d="M10 9H8" />
            <path d="M16 13H8" />
            <path d="M16 17H8" />
        </svg>
    </button>
</div>
