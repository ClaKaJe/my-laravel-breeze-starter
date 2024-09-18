<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div class="mb-6">
            <x-input label="Email" name="email" model="form.email" type="email" icon="o-envelope" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input label="Password" name="password" model="form.password" type="password" icon="o-lock-closed" />
        </div>
        
        <div class="flex items-center justify-between mt-4">
            <!-- Remember Me -->
            <x-mary-checkbox label="Remember Me" wire:model="form.remember" />

            @if (Route::has('password.request'))
                <a class="text-blue-600 dark:text-blue-400 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <x-expandable-submit-button class="ms-3">
            {{ __('Log in') }}
        </x-expandable-submit-button>
    </form>
</div>
