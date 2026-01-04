<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Gerenciamento de Usuários</h3>
            <button x-on:click="$dispatch('user-create')" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo
            </button>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total de Usuários --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total de Usuários</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="user-group" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Usuários Ativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Usuários Ativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->ativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="check-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Usuários Inativos --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-100">Usuários Inativos</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->inativos, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="x-circle" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Administradores --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Administradores</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats->admins, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-30 rounded-lg">
                            <x-ui-icon name="shield-check" class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Ramal, Nome, Email"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        </div>

        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800 rounded-lg">
            <x-tables.table>

                <x-slot name=header>
                    <x-tables.th label="#" column="id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Nome" column="name" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Email" column="email" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Cliente" column="customer_id" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Acesso" column="rule" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Criado" column="created_at" :direction="$direction" :sort="$sort" />
                    <x-tables.th label="Ações" />
                </x-slot>

                <x-slot name=body>
                    @forelse ($users as $user)
                        <x-tables.tr>
                            <x-tables.td class="py-2">{{ $user->id }}</x-tables.td>
                            <x-tables.td class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                        @if($user->ativo)
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Ativo</span>
                                        @else
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Inativo</span>
                                        @endif
                                    </div>
                                </div>
                            </x-tables.td>
                            <x-tables.td class="py-2">{{ $user->email }}</x-tables.td>
                            <x-tables.td class="py-2">
                                @if($user->customer)
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->customer->nomefantasia }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $user->customer->razaosocial }}</div>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td class="py-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($user->rule->value === 'admin') bg-purple-100 text-purple-800
                                    @elseif($user->rule->value === 'customer') bg-blue-100 text-blue-800
                                    @elseif($user->rule->value === 'operator') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $user->rule->label() }}
                                </span>
                            </x-tables.td>
                            <x-tables.td class="py-2">{{ date('d/m/Y H:i', strtotime($user->created_at)) }}
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('user-update', {{ $user }})"
                                    wire:key='update-{{ $user->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="pencil-square" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Editar</span>
                                </span>

                                <span x-on:click="$dispatch('user-delete', {{ $user }})"
                                    wire:key='delete-{{ $user->id }}'
                                    class="inline-flex items-center ml-4 font-medium text-red-500 transition cursor-pointer hover:text-red-700 duration- dark:text-red-500">
                                    <x-ui-icon name="trash" class="w-5 h-5 m-0" />
                                    <span class="ml-1">Excluir</span>
                                </span>

                            </x-tables.td>
                        </x-tables.tr>

                    @empty
                        <x-empty-state
                            colspan="7"
                            icon="users"
                            message="Nenhum usuário encontrado"
                            hint="Tente ajustar os filtros ou criar um novo usuário"
                        />
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $users->links('vendor.livewire.paginate') }}

    <!-- Modal de Filtros -->
    <x-ui-modal wire:model="filterModal" id="filter-modal" size="lg">
        <x-slot:title>
            Filtrar Usuários
        </x-slot:title>

        <div class="space-y-4">
            <!-- Filtro por Perfil/Role -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Perfil de Acesso
                </label>
                <select wire:model="filterRole"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Todos os perfis</option>
                    @foreach($roles as $role)
                        <option value="{{ $role['value'] }}">{{ $role['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Status -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select wire:model="filterStatus"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Todos os status</option>
                    <option value="1">Ativos</option>
                    <option value="0">Inativos</option>
                </select>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <button wire:click="closeFilterModal" type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </button>
                <button wire:click="applyFilters" type="button"
                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Aplicar Filtros
                </button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <livewire:users.create />
    <livewire:users.update />
    <livewire:users.delete />
</div>
