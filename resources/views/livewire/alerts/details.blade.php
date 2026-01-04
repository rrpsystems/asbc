<div>
    <x-ui-modal wire="detailsModal" title="Detalhes do Alerta" size="3xl">

        @if ($selectedAlert)
            <div class="space-y-4">
                <!-- Header with Severity -->
                <div class="flex items-start justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $selectedAlert->title }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $selectedAlert->created_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>

                    <div>
                        @if ($selectedAlert->severity === 'critical')
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                Crítico
                            </span>
                        @elseif($selectedAlert->severity === 'high')
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                Alto
                            </span>
                        @elseif($selectedAlert->severity === 'medium')
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                Médio
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                Baixo
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Message -->
                <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ $selectedAlert->message }}
                    </p>
                </div>

                <!-- Related Entity Info -->
                @if ($selectedAlert->customer || $selectedAlert->carrier)
                    <div class="grid grid-cols-2 gap-4">
                        @if ($selectedAlert->customer)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cliente</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $selectedAlert->customer->razaosocial }}
                                </p>
                            </div>
                        @endif

                        @if ($selectedAlert->carrier)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Operadora</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $selectedAlert->carrier->operadora }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Metadata -->
                @if ($selectedAlert->metadata)
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Informações
                            Adicionais</label>
                        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <dl class="space-y-2">
                                @foreach ($selectedAlert->metadata as $key => $value)
                                    <div class="flex justify-between text-sm">
                                        <dt class="font-medium text-gray-600 dark:text-gray-400">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                        </dt>
                                        <dd class="text-gray-900 dark:text-gray-100">
                                            @if (is_numeric($value))
                                                {{ number_format($value, 2, ',', '.') }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                @endif

                <!-- Status Info -->
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status de
                            Leitura</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if ($selectedAlert->isRead())
                                Lido em {{ $selectedAlert->read_at->format('d/m/Y H:i') }}
                            @else
                                Não lido
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status de
                            Resolução</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if ($selectedAlert->isResolved())
                                Resolvido em {{ $selectedAlert->resolved_at->format('d/m/Y H:i') }}
                            @else
                                Pendente
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex justify-between w-full">
                    <x-ui-button wire:click="detailsModal = false" text="Fechar" color="white" />

                    @if (!$selectedAlert->isResolved())
                        <x-ui-button wire:click="markAsResolved({{ $selectedAlert->id }})" text="Marcar como Resolvido"
                            color="green" />
                    @endif
                </div>
            </x-slot:footer>
        @endif

    </x-ui-modal>
</div>
