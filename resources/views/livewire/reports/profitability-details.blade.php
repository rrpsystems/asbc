<div>
    <x-ui-modal wire="detailsModal" title="Histórico de Rentabilidade" size="4xl">

        @if ($selectedCustomer)
            <div class="space-y-4">
                <!-- Customer Info -->
                <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $selectedCustomer->razaosocial }}
                    </h3>
                    @if ($selectedCustomer->nomefantasia && $selectedCustomer->nomefantasia !== $selectedCustomer->razaosocial)
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $selectedCustomer->nomefantasia }}
                        </p>
                    @endif
                </div>

                <!-- History Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Período
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Receita Total
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Custo Total
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Produtos
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Margem
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Rent. %
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @forelse ($customerHistory as $history)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $history['periodo'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-600 dark:text-blue-400">
                                        R$ {{ number_format($history['receita_total'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-red-600 dark:text-red-400">
                                        R$ {{ number_format($history['custo_total'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        R$ {{ number_format($history['produtos_receita'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold {{ $history['margem_lucro'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        R$ {{ number_format($history['margem_lucro'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $history['percentual'] >= 20 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($history['percentual'] >= 10 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                            {{ number_format($history['percentual'], 1, ',', '.') }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-sm text-center text-gray-500">
                                        Nenhum histórico disponível
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-800">
                    <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Legenda de Rentabilidade:</p>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                            <span class="text-gray-600 dark:text-gray-400">Excelente (≥ 20%)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full"></span>
                            <span class="text-gray-600 dark:text-gray-400">Bom (10-20%)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="text-gray-600 dark:text-gray-400">Atenção (< 10%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex justify-end">
                    <x-ui-button wire:click="detailsModal = false" text="Fechar" color="white" />
                </div>
            </x-slot:footer>
        @endif

    </x-ui-modal>
</div>
