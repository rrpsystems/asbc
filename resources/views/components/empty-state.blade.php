{{-- Componente de Empty State Padronizado --}}
@props([
    'colspan' => '10',
    'icon' => 'magnifying-glass',
    'message' => 'Nenhum registro encontrado',
    'hint' => 'Tente ajustar os filtros ou a busca'
])

<tr>
    <td colspan="{{ $colspan }}" class="px-6 py-16 text-center">
        <div class="flex flex-col items-center justify-center">
            <x-ui-icon name="{{ $icon }}" class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" />
            <p class="text-lg font-medium text-gray-500 dark:text-gray-400">{{ $message }}</p>
            @if($hint)
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">{{ $hint }}</p>
            @endif
        </div>
    </td>
</tr>
