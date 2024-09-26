<div>
    <div x-data
        class="fixed top-0 left-0 z-50 w-64 h-full p-4 transition-transform bg-gray-900 {{ $sideToggle ? '' : '-translate-x-full' }}">

        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img class="object-cover w-12 h-12" src="{{ asset('img/logo_1.png') }}" alt="logo">
            {{-- <img src="https://placehold.co/32x32" alt="" class="object-cover w-8 h-8 rounded"> --}}
            <span class="ml-3 text-lg font-bold text-white">RRP Systems
            </span>
        </a>

        <ul class="mt-4">

            <x-sidebar.menu name="Dashboard" :href="route('dashboard')" routename="dashboard">
                <x-icons.home class="mr-3 text-lg" h=18 w=18 />
            </x-sidebar.menu>


            <x-sidebar.group-menu name="Relatórios" routename="report" :$dropdown>
                <x-slot name="icon">
                    <x-icons.box class="mr-3 text-lg" h=18 w=18 />
                </x-slot name="icon">

                <x-sidebar.group-item name="Detalhado" :href="route('orders')" routename="orders" />
                <x-sidebar.group-item name="Mensal" :href="route('orders')" routename="orders" />
                <x-sidebar.group-item name="Anual" :href="route('orders')" routename="orders" />
                <x-sidebar.group-item name="Faturas" :href="route('orders')" routename="orders" />
                <x-sidebar.group-item name="Log CDR" :href="route('report.cdr')" routename="report/cdr" />

            </x-sidebar.group-menu>

            <x-sidebar.group-menu name="Configurações" routename="config" :$dropdown>
                <x-slot name="icon">
                    <x-icons.settings class="mr-3 text-lg" h=18 w=18 />
                </x-slot name="icon">

                <x-sidebar.group-item name="Usuarios" :href="route('config.user')" routename="config/user" />
                <x-sidebar.group-item name="Clientes" :href="route('config.customer')" routename="config/customer" />
                <x-sidebar.group-item name="Operadoras" :href="route('config.carrier')" routename="config/carrier" />
                <x-sidebar.group-item name="DIDs" :href="route('config.did')" routename="config/did" />
                <x-sidebar.group-item name="Tarifas" :href="route('config.rate')" routename="config/rate" />

            </x-sidebar.group-menu>

        </ul>




    </div>
    <div class="fixed top-0 left-0 z-40 w-full h-full bg-black/50 md:hidden sidebar-overlay {{ $sideToggle ? '' : 'hidden' }}"
        wire:click="$dispatch('close-sidebar')">
    </div>

</div>
