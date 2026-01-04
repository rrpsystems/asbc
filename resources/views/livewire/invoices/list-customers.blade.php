<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Relatórios', 'Faturas'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">
                Faturas por Cliente
            </h3>
            <button wire:click="refresh" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Atualizar
            </button>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-5">
            <!-- Total de Clientes -->
            <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Total de Clientes</p>
                        <p class="text-2xl font-bold text-white">{{ $totalClientes }}</p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total de Faturas -->
            <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Total de Faturas</p>
                        <p class="text-2xl font-bold text-white">{{ $totalFaturas }}</p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Faturas Abertas -->
            <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-100">Faturas Abertas</p>
                        <p class="text-2xl font-bold text-white">{{ $faturasAbertas }}</p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Faturas Fechadas -->
            <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-100">Faturas Fechadas</p>
                        <p class="text-2xl font-bold text-white">{{ $faturasFechadas }}</p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Receita Total -->
            <div class="p-4 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-emerald-100">Receita Total</p>
                        <p class="text-2xl font-bold text-white">R$ {{ number_format($receitaTotal, 2, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Buscar cliente..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        </div>

        <!-- Tabela de Clientes -->
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Cliente</th>
                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Total Faturas</th>
                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Última Fatura</th>
                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $customer->nomefantasia ?? $customer->razaosocial }}
                                    </p>
                                    @if($customer->nomefantasia && $customer->razaosocial != $customer->nomefantasia)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->razaosocial }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $customer->faturas_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($customer->revenueSummaries->isNotEmpty())
                                    @php
                                        $lastInvoice = $customer->revenueSummaries->first();
                                    @endphp
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ str_pad($lastInvoice->mes, 2, '0', STR_PAD_LEFT) }}/{{ $lastInvoice->ano }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('customers.invoices', $customer->id) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Ver Faturas
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                <p class="text-lg">Nenhum cliente encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links('vendor.livewire.paginate') }}
        </div>
    </div>
</div>
