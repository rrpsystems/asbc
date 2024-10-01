<div wire:poll.1000ms
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Dashboard</h3>

        </div>

        {{-- <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">

            <div class="col-span-12 xl:col-span-8">
                <div
                    class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <h4 class="mb-6 text-xl font-bold text-black dark:text-white">
                        Top Channels
                    </h4>

                    <div class="flex flex-col">
                        <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
                            <div class="p-2.5 xl:p-5">
                                <h5 class="text-sm font-medium uppercase xsm:text-base">Source</h5>
                            </div>
                            <div class="p-2.5 text-center xl:p-5">
                                <h5 class="text-sm font-medium uppercase xsm:text-base">Visitors</h5>
                            </div>
                            <div class="p-2.5 text-center xl:p-5">
                                <h5 class="text-sm font-medium uppercase xsm:text-base">Revenues</h5>
                            </div>
                            <div class="hidden p-2.5 text-center sm:block xl:p-5">
                                <h5 class="text-sm font-medium uppercase xsm:text-base">Sales</h5>
                            </div>
                            <div class="hidden p-2.5 text-center sm:block xl:p-5">
                                <h5 class="text-sm font-medium uppercase xsm:text-base">Conversion</h5>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <div class="flex-shrink-0">
                                    <img src="src/images/brand/brand-01.svg" alt="Brand">
                                </div>
                                <p class="hidden font-medium text-black dark:text-white sm:block">
                                    Google
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-black dark:text-white">3.5K</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-meta-3">$5,768</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-black dark:text-white">590</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-meta-5">4.8%</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <div class="flex-shrink-0">
                                    <img src="src/images/brand/brand-02.svg" alt="Brand">
                                </div>
                                <p class="hidden font-medium text-black dark:text-white sm:block">
                                    Twitter
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-black dark:text-white">2.2K</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-meta-3">$4,635</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-black dark:text-white">467</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-meta-5">4.3%</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <div class="flex-shrink-0">
                                    <img src="src/images/brand/brand-03.svg" alt="Brand">
                                </div>
                                <p class="hidden font-medium text-black dark:text-white sm:block">
                                    Github
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-black dark:text-white">2.1K</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-meta-3">$4,290</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-black dark:text-white">420</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-meta-5">3.7%</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <div class="flex-shrink-0">
                                    <img src="src/images/brand/brand-04.svg" alt="Brand">
                                </div>
                                <p class="hidden font-medium text-black dark:text-white sm:block">
                                    Vimeo
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-black dark:text-white">1.5K</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-meta-3">$3,580</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-black dark:text-white">389</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-meta-5">2.5%</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <div class="flex-shrink-0">
                                    <img src="src/images/brand/brand-05.svg" alt="Brand">
                                </div>
                                <p class="hidden font-medium text-black dark:text-white sm:block">
                                    Facebook
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-black dark:text-white">1.2K</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="font-medium text-meta-3">$2,740</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-black dark:text-white">230</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="font-medium text-meta-5">1.9%</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> --}}
        <div
            class="col-span-12 bg-white border rounded-sm border-stroke p-7 shadow-default dark:border-gray-600 dark:bg-gray-800">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 xl:gap-0">

                <div class="flex items-center justify-center gap-2">
                    <div>
                        <h4 class="mb-0.5 text-xl font-bold text-black dark:text-white md:text-title-lg">
                            2m 56s
                        </h4>
                        <p class="text-sm text-black dark:text-white">Visit Duration</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.25259 5.87281L4.22834 9.89706L3.16751 8.83623L9.00282 3.00092L14.8381 8.83623L13.7773 9.89705L9.75306 5.87281L9.75306 15.0046L8.25259 15.0046L8.25259 5.87281Z"
                                fill="#10B981"></path>
                        </svg>
                        <span class="text-meta-3 text">12%</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="p-10 overflow-x-auto bg-white shadow-md dark:bg-gray-800">


            <span class="p-10 text-white">Teste:{{ $teste ?? '' }}</span><br><br>
            <span class="p-10 text-white">Tempo: {{ $tempo ?? '' }}</span><br><br>
            <span class="p-10 text-white">Valor: {{ $valor ?? '' }}</span><br><br>

            <div class="grid justify-between grid-cols-3 gap-4 mb-6">

                <table class="grid-cols-1 divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                    <thead class="text-white bg-sky-800 dark:bg-sky-950 dark:text-gray-400">
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Horario
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Operadora
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Cliente
                        </th>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                        @forelse ($data as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->hour }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->max_carrier_channels }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->max_customer_channels }}
                                </td>

                            </tr>
                        @empty
                            Sem dados
                        @endforelse
                    </tbody>

                </table>

                <table class="grid-cols-1 divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                    <thead class="text-white bg-sky-800 dark:bg-sky-950 dark:text-gray-400">
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Posição
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Canais
                        </th>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                        @forelse ($data1 as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->customer->razaosocial, 25) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->max_customer_channels }}
                                </td>
                            </tr>
                        @empty
                            Sem dados
                        @endforelse
                    </tbody>

                </table>

                <table class="grid-cols-1 divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                    <thead class="text-white bg-sky-800 dark:bg-sky-950 dark:text-gray-400">
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Posição
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Chamadas
                        </th>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
                        @forelse ($data2 as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->customer->razaosocial, 15) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->max_customer_calls }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->total_billsec }}
                                </td>
                            </tr>
                        @empty
                            Sem dados
                        @endforelse
                    </tbody>

                </table>

            </div>


        </div>
    </div>

</div>
