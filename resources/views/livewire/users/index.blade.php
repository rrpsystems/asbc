<div
    class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">Lista de Usuarios</h3>
            <x-buttons.group btnCreate="user-create" />
        </div>
        <div class="overflow-x-auto bg-white shadow-md dark:bg-gray-800">
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
                            <x-tables.td class="py-2">{{ $user->name }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $user->email }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $user->customer_id }}</x-tables.td>
                            <x-tables.td class="py-2">{{ $user->rule }}</x-tables.td>
                            <x-tables.td class="py-2">{{ date('d/m/Y H:i', strtotime($user->created_at)) }}
                            </x-tables.td>
                            <x-tables.td class="py-0">

                                <span x-on:click="$dispatch('user-update', {{ $user }})"
                                    wire:key='update-{{ $user->id }}'
                                    class="inline-flex items-center font-medium text-yellow-500 transition cursor-pointer hover:text-yellow-700 duration- dark:text-yellow-500">
                                    <x-ui-icon name="edit" class="w-5 h-5 m-0" />
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
                        Sem Dados
                    @endforelse
                </x-slot>
            </x-tables.table>

        </div>
    </div>
    {{ $users->links('vendor.livewire.paginate') }}
    <livewire:users.create />
    <livewire:users.update />
    <livewire:users.delete />
</div>
