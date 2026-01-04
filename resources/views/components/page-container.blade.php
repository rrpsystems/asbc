{{-- Componente de Container Padrão para Páginas --}}
@props(['title' => '', 'breadcrumb' => []])

<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    @if(count($breadcrumb) > 0)
        <div x-init="$dispatch('bradcrumb', { menu: @js($breadcrumb) })"></div>
    @endif

    <div class="container flex-grow mx-auto">
        @if($title || isset($header))
            <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
                @if($title)
                    <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">{{ $title }}</h3>
                @endif

                @if(isset($header))
                    {{ $header }}
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>

    @if(isset($footer))
        {{ $footer }}
    @endif
</div>
