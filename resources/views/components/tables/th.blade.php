{{-- @props(['first' => null, 'label' => null, 'column' => null, 'sort' => null, 'direction' => null])

<th scope="col" {{ $attributes->class([
        'py-3.5 text-left text-sm font-semibold text-gray-900',
        'px-3'              => ! $first,
        'pl-4 pr-3 sm:pl-6' => $first,
    ]) }}>
    <a href="#" class="inline-flex truncate cursor-pointer group text-primary"
       @if ($sort && $column && $direction) wire:click.prevent="sort('{{ $column }}', '{{ $sort === $column ? ($direction === 'asc' ? 'desc' : 'asc') : 'desc' }}')" @endif>

        {{ $label ?? $slot }}
        <span class="flex-none ml-2 rounded">

            @if ($sort === $column && $direction === 'asc')
                <x-heroicon-s-chevron-up class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @elseif ($sort === $column && $direction === 'desc')
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif

            @if ($sort !== $column)
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif
        </span>
    </a> --}}


@props(['label' => null, 'column' => null, 'sort' => null, 'direction' => null])


<th {{ $attributes->class([
    'px-4 py-3 text-sm font-medium tracking-wider text-left uppercase whitespace-nowrap',
    'border-b-4 border-cyan-400' => $column == $sort && $column != null,
]) }}
    @isset($column)
    wire:click="sortBy('{{ $column }}')"
    @endisset>

    <span class="flex items-center justify-start ml-2 text-gray-300 whitespace-nowrap">
        {{ $label }}

        @isset($column)
            @if ($column == $sort && $direction == 'asc')
                <x-icons.asc w-2 h-2 class="ml-2" />
            @elseif ($column == $sort && $direction == 'desc')
                <x-icons.desc w-2 h-2 class="ml-2" />
            @else
                <x-icons.asc-desc w-2 h-2 class="whitespace-nowrap" class="ml-2" />
            @endif
        @endisset

    </span>
</th>
{{-- @props(['name', 'value', 'sortKey' => null, 'sortDirection' => null])


@if ($name == $sortKey)
    <th
        class="px-4 py-3 text-sm font-medium tracking-wider text-left uppercase border-b-4 whitespace-nowrap border-cyan-400">
    @else
    <th class="px-4 py-3 text-sm font-medium tracking-wider text-left uppercase whitespace-nowrap">
@endif


<span class="flex items-center justify-start ml-2 text-gray-300 whitespace-nowrap">
    {{ $name }}

    @if ($name == $sortKey && $sortDirection == 'asc')
        <x-icons.asc w-4 h-4 class="ml-2" />
    @elseif ($name == $sortKey && $sortDirection == 'desc')
        <x-icons.desc w-4 h-4 class="ml-2" />
    @else
        <x-icons.asc-desc w-4 h-4 class="whitespace-nowrap" class="ml-2" />
    @endif

</span>
</th> --}}
