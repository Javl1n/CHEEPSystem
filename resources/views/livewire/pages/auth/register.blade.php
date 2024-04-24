<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\{ layout, rules, state, usesFileUploads };

usesFileUploads();

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
    // 'part' => 1,
    'role' => 3,
    'photo'
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    'photo' => 'required|image',
]);

$setRoleButton = function ($role) {
    $this->role = $role;
};

$register = function () {
    $this->validate();

    $this->role = Role::where('id', $this->role)->first();

    $user = $this->role->users()->create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password),
    ]);

    $user->profile()->create([
        'url' => 'storage/images/empty_profile.png'
    ]);

    $user->verification()->create()->file()->create([
        'url' => $this->photo->store('images/verifications')
    ]);

    event(new Registered($user));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<div class="">
        {{-- @if ($part === 1) --}}
            <div>
                <!-- Role -->
                <div class="">
                    <x-input-label for="grade" :value="__('Your Role')" />
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-center">
                            <button class="{{ $role === 3 ? 'bg-green-500 text-white' : 'text-gray-600'  }} font-bold text-gray-600 text-sm w-full py-2 transition linear rounded shadow-sm border border-gray-300" x-on:click.prevent="$wire.setRoleButton(3)">
                                Student
                            </button>
                        </div>
                        <div class="text-center">
                            <button class="{{ $role === 2 ? 'bg-orange-600 text-white' : 'text-gray-600'  }} font-bold  text-sm w-full py-2 transition linear rounded shadow-sm border border-gray-300" x-on:click.prevent="$wire.setRoleButton(2)">
                                Teacher
                            </button>
                        </div>
                    </div>
                    {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                </div>

                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                {{-- <div class="flex items-center justify-end mt-4">
                    <a
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}"
                        wire:navigate
                    >
                        {{ __('Already registered?') }}
                    </a>
                    <a class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" x-on:click="$wire.nextPart">
                        {{ __('Next') }}
                    </a>
                </div> --}}
            </div>
        {{-- @endif
        @if ($part === 2) --}}
            <div>
                <!-- Photo -->
                <div class="mt-4">
                    <x-input-label for="grade" :value="__('Verify Account')" />
                    <x-image-upload model="photo" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>
                <div class="flex justify-end mt-4">
                    {{-- <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" x-on:click="$wire.prevPart">
                        {{ __('Go back') }}
                    </a> --}}
                    <div class="">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button wire:click="register" class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        {{-- @endif --}}
</div>
