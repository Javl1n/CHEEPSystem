<?php

use function Livewire\Volt\{state, layout};
use App\Models\User;

state([
    'users' => User::whereNot('role_id', 1)->with([
        'verification' => ['file'],
        'role',
        'profile'
    ])->latest()->get()
]);

layout('layouts.app');

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 lg:px-8 max-w-5xl mx-auto">
        <div class="col-span-2">
            {{-- @livewire('post.create') --}}
            @foreach ($users as $user)
                <div class="{{ $loop->first ? '' : 'mt-4' }}">
                    @livewire('users.show', ['user' => $user])
                </div>
            @endforeach
        </div>
        {{-- <div class="col-span-1">
            @livewire('users.navigate')
        </div> --}}
    </div>
</div>
