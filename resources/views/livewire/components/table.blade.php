<div>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">
        <thead class="text-white bg-sky-800 dark:bg-sky-950 dark:text-gray-400">
            <tr>
                @foreach ($headers as $header)
                    <x-tables.th name="{{ $header }}" />
                @endforeach
                {{-- <x-tables.th name="Ramal" sortKey="Ramal" sortDirection="asc" />
                <x-tables.th name="Usuario" />
                <x-tables.th name="Departamento" />
                <x-tables.th name="Ações" /> --}}
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">

            @for ($i = 1; $i <= 8; $i++)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                    <td class="px-4 py-2 font-medium whitespace-nowrap">{{ $i }}</td>
                    <td class="px-4 py-2 font-medium whitespace-nowrap">10{{ $i }}</td>
                    <td class="px-4 py-2 font-medium whitespace-nowrap">Maria Oliveira</td>
                    <td class="px-4 py-2 font-medium whitespace-nowrap">Suporte</td>
                    <td class="flex items-center px-4 py-2 font-medium whitespace-nowrap">

                        <x-ui-link x-on:click="$slideOpen('edit-id')" class="mr-2" href="#" text="Editar"
                            color="blue" bold wire:key="edit-{{ $i }}" />

                        <x-ui-link x-on:click="$slideOpen('delete-id')" href="#" text="Excluir" color="red"
                            bold wire:key='delete-{{ $i }}' />

                    </td>
                </tr>
            @endfor

            <!-- Repetir TR para cada ramal -->
        </tbody>
    </table>

</div>
