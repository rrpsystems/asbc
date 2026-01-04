<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <section class="relative w-full min-h-screen gradient-form bg-gradient-to-br from-slate-100 via-blue-50 to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 overflow-hidden">

        <!-- Background Animated Circles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-40">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-300 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl animate-blob"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-300 dark:bg-emerald-600 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-24 left-1/2 w-96 h-96 bg-blue-300 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative flex flex-wrap items-center justify-center w-full min-h-screen p-6 md:p-10">

            <div class="flex flex-wrap items-center justify-center w-full text-neutral-800 dark:text-neutral-200">

                <div class="w-full max-w-6xl">
                    <div class="block h-full bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-neutral-700/50">
                        <div class="items-center g-0 lg:flex lg:flex-wrap">
                            <!-- Left column container-->
                            <div class="flex justify-center px-4 md:px-0 lg:w-6/12">
                                <div class="w-full md:mx-6 md:p-12 p-8">
                                    <div class="text-center mb-8">
                                        <!-- Icon Badge -->
                                        <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-cyan-500 to-emerald-500 rounded-2xl shadow-lg transform hover:scale-110 transition-transform duration-300">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>

                                        <h3 class="pb-1 mt-1 mb-3 text-3xl font-bold bg-gradient-to-r from-cyan-600 to-emerald-600 bg-clip-text text-transparent dark:from-cyan-400 dark:to-emerald-400">
                                            Bem-vindo de volta!
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">
                                            Sistema de Gestão Telefônica
                                        </p>
                                    </div>

                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form wire:submit="login" class="max-w-md space-y-5">

                                        <!--Username input-->
                                        <div class="space-y-2">
                                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                E-mail
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                <x-text-input wire:model="form.email" id="email"
                                                    class="block w-full pl-10 pr-3 py-3 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-all duration-200"
                                                    type="email" name="email" required
                                                    autofocus autocomplete="username" placeholder="seu@email.com" />
                                            </div>
                                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                                        </div>

                                        <!--Password input-->
                                        <div class="space-y-2">
                                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Senha
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    </svg>
                                                </div>
                                                <x-text-input wire:model="form.password" id="password"
                                                    placeholder="••••••••"
                                                    class="block w-full pl-10 pr-3 py-3 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-all duration-200"
                                                    type="password" name="password" required
                                                    autocomplete="current-password" />
                                            </div>
                                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                                        </div>

                                        <!--Submit button-->
                                        <div class="pt-2 space-y-4">
                                            <button
                                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-base font-semibold text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                                                type="submit"
                                                style="background: linear-gradient(to right, #00a9ce, #00d084, #28a745);">
                                                <span>Entrar no Sistema</span>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </button>

                                            <!--Forgot password link-->
                                            @if (Route::has('password.request'))
                                                <div class="text-center">
                                                    <a class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors duration-200"
                                                        href="{{ route('password.request') }}" wire:navigate>
                                                        {{ __('Forgot your password?') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </form>

                                    <!-- Footer -->
                                    <div class="mt-8 text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            © 2025 RRP Systems. Todos os direitos reservados.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right column container with background and description-->
                            <div class="relative flex items-center justify-center min-h-[calc(100vh-5rem)] rounded-b-2xl lg:w-6/12 lg:rounded-e-2xl lg:rounded-bl-none overflow-hidden"
                                style="background: linear-gradient(135deg, #00a9ce, #00d084, #28a745);">

                                <!-- Decorative Elements -->
                                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 backdrop-blur-sm"></div>
                                <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full -ml-40 -mb-40 backdrop-blur-sm"></div>

                                <div class="relative z-10 px-4 py-8 text-white md:mx-6 md:p-12">
                                    <div class="flex justify-center mb-8">
                                        <div class="transform hover:scale-105 transition-transform duration-300">
                                            <img class="object-contain max-h-48 drop-shadow-2xl" src="{{ asset('img/logo_1.png') }}"
                                                alt="RRP Systems Logo">
                                        </div>
                                    </div>

                                    <div class="text-center space-y-4 mb-8">
                                        <h4 class="text-3xl font-bold drop-shadow-lg">
                                            RRP Systems
                                        </h4>
                                        <p class="text-lg text-white/90 max-w-md mx-auto leading-relaxed">
                                            Simplificando as conexões para uma comunicação mais efetiva!
                                        </p>
                                    </div>

                                    <!-- Features List -->
                                    <div class="space-y-3 mb-8 max-w-md mx-auto">
                                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-5 h-5 text-emerald-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Gestão completa de telecomunicações</span>
                                        </div>
                                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-5 h-5 text-emerald-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Relatórios detalhados em tempo real</span>
                                        </div>
                                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-3 transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-5 h-5 text-emerald-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Segurança e confiabilidade garantidas</span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <a href="https://www.rrpsystems.com.br"
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-cyan-600 rounded-xl font-semibold text-sm hover:bg-white/90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            Conheça nossas soluções
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
