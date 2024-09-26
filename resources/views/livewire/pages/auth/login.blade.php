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
    <section class="w-full h-full gradient-form bg-neutral-200 dark:bg-neutral-700">

        <div class="flex flex-wrap items-center justify-center w-full p-10">

            <div class="flex flex-wrap items-center justify-center w-full text-neutral-800 dark:text-neutral-200">

                <div class="w-full ">
                    <div class="block h-full bg-white rounded-lg shadow-lg dark:bg-neutral-800 ">
                        <div class="items-center g-0 lg:flex lg:flex-wrap">
                            <!-- Left column container-->
                            <div class="flex justify-center px-4 md:px-0 lg:w-6/12">
                                <div class="md:mx-6 md:p-12">
                                    <div class="text-center">

                                        <h3 class="pb-1 mt-1 mb-12 text-2xl font-semibold">
                                            Sistema de Gestão Telefonica <br>

                                        </h3>
                                    </div>

                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form wire:submit="login" class="max-w-md">

                                        <p class="mb-4">Faça o login para acessar o sistema</p>
                                        <!--Username input-->
                                        <div class="relative mb-4">
                                            <x-text-input wire:model="form.email" id="email"
                                                class="block w-full mt-1" type="email" name="email" required
                                                autofocus autocomplete="username" placeholder="{{ __('Usuario') }}" />
                                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                                        </div>

                                        <!--Password input-->
                                        <div class="relative mb-4">
                                            <!-- Password -->

                                            <x-text-input wire:model="form.password" id="password"
                                                placeholder="{{ __('Password') }}" class="block w-full mt-1"
                                                type="password" name="password" required
                                                autocomplete="current-password" />

                                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                                        </div>

                                        <!--Submit button-->
                                        <div class="pt-1 pb-1 mb-12 text-center">
                                            {{-- <x-primary-button class="ms-3">
                                                {{ __('Log in') }}
                                            </x-primary-button> --}}
                                            <button
                                                class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-dark-3 transition duration-150 ease-in-out hover:shadow-dark-2 focus:shadow-dark-2 focus:outline-none focus:ring-0 active:shadow-dark-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                                                type="submit" data-twe-ripple-init data-twe-ripple-color="light"
                                                style="background: linear-gradient(to right, #00a9ce, #00d084, #28a745);">
                                                Entrar
                                            </button>

                                            <!--Forgot password link-->
                                            @if (Route::has('password.request'))
                                                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                                    href="{{ route('password.request') }}" wire:navigate>
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Right column container with background and description-->
                            <div class="flex items-center justify-center min-h-[calc(100vh-5rem)] rounded-b-lg lg:w-6/12 lg:rounded-e-lg lg:rounded-bl-none"
                                style="background: linear-gradient(to right, #00a9ce, #00d084, #28a745);">
                                <div class="px-4 py-6 text-white md:mx-6 md:p-12">
                                    <div class="flex justify-center">
                                        <img class="object-contain max-h-64" src="{{ asset('img/logo_1.png') }}"
                                            alt="logo">
                                    </div>
                                    <div class="grid justify-center mb-6 itens-center col-grid-2">
                                        <h4 class="text-2xl font-semibold text-center">
                                            RRP Systems
                                        </h4>
                                        <span class="text-sm">Simplificando as conexões para uma comunicação mais
                                            efetiva!</span>
                                    </div>
                                    <a href="https://www.rrpsystems.com.br" class="pt-12 text-sm">
                                        Conheça nossas soluções!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
