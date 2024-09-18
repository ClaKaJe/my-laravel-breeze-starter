<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state('token')->locked();

state([
    'email' => fn() => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$resetPassword = function () {
    $this->validate();

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
        $user
            ->forceFill([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])
            ->save();

        event(new PasswordReset($user));
    });

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    if ($status != Password::PASSWORD_RESET) {
        $this->addError('email', __($status));

        return;
    }

    Session::flash('status', __($status));

    $this->redirectRoute('login', navigate: true);
};

?>

<div>
    <form wire:submit="resetPassword">
        <!-- Email Address -->
        <div class="mb-6">
            <x-input label='Email' name='email' model='email' type='email' icon='o-envelope' />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input label="Password" name="password" model="password" type="password" icon="o-lock-closed" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-input label="Confirm Password" name="password_confirmation" model="password_confirmation" type="password"
                icon="o-lock-closed" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-expandable-submit-button>
                {{ __('Reset Password') }}
            </x-expandable-submit-button>
        </div>
    </form>
</div>
