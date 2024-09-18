<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered(($user = User::create($validated))));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div class="mb-6">
            <x-input label="Name" name="name" model="name" icon="o-user" />
        </div>

        <!-- Email Address -->
        <div class="mb-6">
            <x-input label="Email" name="email" model="email" type="email" icon="o-envelope" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input label="Password" name="password" model="password" type="password" icon="o-lock-closed" />
        </div>

        <!-- Confirm Password -->
        <div class="">
            <x-input label="Confirm Password" name="password_confirmation" model="password_confirmation" type="password"
                icon="o-lock-closed" />
        </div>

        <x-expandable-submit-button icon="o-user-plus">
            {{ __('Register') }}
        </x-expandable-submit-button>

        <div class="flex items-center justify-end mt-4 dark:text-gray-200">
            Already registered? &nbsp;
            <a class="text-blue-600 dark:text-blue-400 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}" wire:navigate>
                {{ __('login') }}
            </a>
        </div>
    </form>
</div>
