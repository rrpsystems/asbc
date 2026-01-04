<div x-data="{
        open: $persist(true).as('sidebar-open'),
        dropdowns: {},
        init() {
            this.$watch('open', () => {
                document.body.classList.toggle('sidebar-closed', !this.open);
            });
        },
        toggleDropdown(name) {
            this.dropdowns[name] = !this.dropdowns[name];
        },
        isDropdownOpen(name) {
            return this.dropdowns[name] === true;
        }
    }" @toggle-sidebar.window="open = !open" @resize.window.debounce="if (window.innerWidth < 768) open = false">

    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 z-50 w-64 h-full p-4 overflow-y-auto transition-transform duration-200 ease-in-out bg-gray-900"
        :class="{ '-translate-x-full': !open }">

        <a href="{{ route('dashboard') }}" class="flex items-center pb-4 border-b border-b-gray-800">
            <img class="object-cover w-12 h-12" src="{{ asset('img/logo_1.png') }}" alt="logo">
            <span class="ml-3 text-lg font-bold text-white">RRP Systems</span>
        </a>

        <ul class="mt-4" x-data>

            @if(Auth::user()->rule === App\Enums\UserRole::RESELLER)
                <!-- Menu para Revendas -->
                <x-sidebar.menu name="Dashboard" :href="route('reseller.dashboard')" routename="reseller.dashboard">
                    <x-icons.home class="mr-3 text-lg" h=18 w=18 />
                </x-sidebar.menu>

                <x-sidebar.menu name="Meus Clientes" :href="route('reseller.customers')" routename="reseller.customers">
                    <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </x-sidebar.menu>

                <x-sidebar.menu name="Relatórios" :href="route('reseller.reports')" routename="reseller.reports">
                    <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </x-sidebar.menu>

                <x-sidebar.menu name="Configurações" :href="route('reseller.settings')" routename="reseller.settings">
                    <x-icons.settings class="mr-3 text-lg" h=18 w=18 />
                </x-sidebar.menu>
            @else
                <!-- Menu para Admin/Manager -->
                <x-sidebar.menu name="Dashboard" :href="route('dashboard')" routename="dashboard">
                    <x-icons.home class="mr-3 text-lg" h=18 w=18 />
                </x-sidebar.menu>

                <x-sidebar.menu name="Financeiro" :href="route('dashboard.financial')" routename="dashboard.financial">
                    <x-icons.home class="mr-3 text-lg" h=18 w=18 />
                </x-sidebar.menu>
            @endif

            @if(Auth::user()->rule !== App\Enums\UserRole::RESELLER)
                <x-sidebar.menu name="Alertas" :href="route('alerts.index')" routename="alerts.index">
                    <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </x-sidebar.menu>

                <x-sidebar.menu name="Manutenção" :href="route('maintenance.index')" routename="maintenance.index">
                    <svg class="mr-3 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </x-sidebar.menu>

                <x-sidebar.group-menu name="Relatórios" routename="report" :$dropdown>
                <x-slot name="icon">
                    <x-icons.box class="mr-3 text-lg" h=18 w=18 />
                </x-slot name="icon">

                <x-sidebar.group-item name="Faturas" :href="route('report.invoice')" routename="report/invoice" />
                <x-sidebar.group-item name="Operadoras" :href="route('report.carrier')" routename="report/carrier" />
                <x-sidebar.group-item name="Alocação de Custos" :href="route('report.cost-allocation')"
                    routename="report/cost-allocation" />
                <x-sidebar.group-item name="Qualidade de Tráfego (ASR/ACD)" :href="route('report.quality-analysis')"
                    routename="report/quality-analysis" />
                <x-sidebar.group-item name="Rentabilidade" :href="route('report.profitability')"
                    routename="report/profitability" />
                <x-sidebar.group-item name="Previsão de Faturamento" :href="route('report.revenue-forecast')"
                    routename="report/revenue-forecast" />
                <x-sidebar.group-item name="Detecção de Fraude" :href="route('report.fraud-detection')"
                    routename="report/fraud-detection" />
                <x-sidebar.group-item name="Análise de Rotas (LCR)" :href="route('report.route-analysis')"
                    routename="report/route-analysis" />
                <x-sidebar.group-item name="Log CDR" :href="route('report.cdr')" routename="report/cdr" />

                </x-sidebar.group-menu>

                <x-sidebar.group-menu name="Gestão" routename="customers" :$dropdown>
                    <x-slot name="icon">
                        <x-icons.box class="mr-3 text-lg" h=18 w=18 />
                    </x-slot name="icon">

                    <x-sidebar.group-item name="Produtos/Serviços" :href="route('customers.products.list')"
                        routename="customers/products" />

                </x-sidebar.group-menu>

                <x-sidebar.group-menu name="Configurações" routename="config" :$dropdown>
                    <x-slot name="icon">
                        <x-icons.settings class="mr-3 text-lg" h=18 w=18 />
                    </x-slot name="icon">

                    <x-sidebar.group-item name="Usuarios" :href="route('config.user')" routename="config/user" />
                    <x-sidebar.group-item name="Clientes" :href="route('config.customer')" routename="config/customer" />
                    <x-sidebar.group-item name="Revendas" :href="route('config.reseller')" routename="config/reseller" />
                    <x-sidebar.group-item name="Operadoras" :href="route('config.carrier')" routename="config/carrier" />
                    <x-sidebar.group-item name="DIDs" :href="route('config.did')" routename="config/did" />
                    <x-sidebar.group-item name="Tarifas" :href="route('config.rate')" routename="config/rate" />
                    <x-sidebar.group-item name="Áudios" :href="route('config.audio')" routename="config/audio" />

                </x-sidebar.group-menu>
            @endif

        </ul>

    </aside>

    <!-- Overlay para mobile -->
    <div x-show="open && window.innerWidth < 768" x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 z-40 bg-black/50 md:hidden">
    </div>

</div>