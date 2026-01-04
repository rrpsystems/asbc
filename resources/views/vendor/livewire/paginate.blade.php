<div>
    @if ($paginator->hasPages())

        <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <span>{!! __('Showing') !!}</span>
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                <span>{!! __('to') !!}</span>
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->total() }}</span>
                <span>{!! __('results') !!}</span>
            </div>

            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <label class="inline-flex items-center cursor-pointer">
                    <span class="block">
                        <select wire:model.live="perPage" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 appearance-auto">
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </span>
                    <span
                        class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">{!! __('Itens') !!}</span>
                </label>
            </div>

            <div class="mb-1 space-x-2 sm:mb-0">
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center h-8 -space-x-px text-sm">
                        <li>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <button disabled
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                </button>
                            @else
                                <button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                </button>
                            @endif
                        </li>

                        @php
                            // Quantidade de páginas a mostrar antes e depois da página atual
                            $sidePages = 2;
                            $currentPage = $paginator->currentPage();
                            $lastPage = $paginator->lastPage();
                        @endphp

                        {{-- Show first page --}}
                        @if ($currentPage > $sidePages + 1)
                            <li>
                                <button wire:click="gotoPage(1)"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</button>
                                {{-- Show the three dots separator if not on the second page --}}
                            </li>
                            @if ($currentPage > $sidePages + 2)
                                <li>
                                    <button disabled
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ">...</button>
                                </li>
                            @endif
                        @endif

                        {{-- Display Pages Around the Current Page --}}
                        @for ($i = max(1, $currentPage - $sidePages); $i <= min($currentPage + $sidePages, $lastPage); $i++)
                            <li>
                                @if ($i == $currentPage)
                                    <button aria-current="page" disabled
                                        class="z-10 flex items-center justify-center h-8 px-3 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $i }})"
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</button>
                                @endif
                            </li>
                        @endfor


                        @if ($currentPage < $lastPage - $sidePages)
                            {{-- Show the three dots separator if not on the penultimate page --}}
                            @if ($currentPage < $lastPage - $sidePages - 1)
                                <li>
                                    <button disabled
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">...</button>
                                </li>
                            @endif

                            <li>
                                <button wire:click="gotoPage({{ $lastPage }})"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $lastPage }}</button>
                            </li>
                        @endif


                        {{-- Next Page Link --}}
                        <li>
                            @if ($paginator->hasMorePages())
                                <button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </button>
                            @else
                                <button disabled
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </button>
                            @endif

                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <span>{!! __('Showing') !!}</span>
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                <span>{!! __('to') !!}</span>
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->total() }}</span>
                <span>{!! __('results') !!}</span>
            </div>

            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <label class="inline-flex items-center cursor-pointer">
                    <span class="block">
                        <select wire:model.live="perPage" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 appearance-auto">
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </span>
                    <span
                        class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">{!! __('Itens') !!}</span>
                </label>
            </div>

            <div class="mb-1 space-x-2 sm:mb-0">
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center h-8 -space-x-px text-sm">

                    </ul>
                </nav>

            </div>
        </div>
    @endif

</div>
