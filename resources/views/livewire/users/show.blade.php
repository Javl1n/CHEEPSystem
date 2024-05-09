<?php

use function Livewire\Volt\{state};

state([
    'user'
]);

$verifyUser = function () {
    $this->user->verification->update([
        'verified' => true
    ]);
};

$restrictUser = function () {
    $status = $this->user->restricted;
    $this->user->update([
        'restricted' => !$status
    ]);
};

?>

<div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex gap-2">
            <x-profile-picture class="h-12 shadow" src="{{ asset($user->profile->url) }}" />
            <div class="flex-1">
                <div class="flex justify-between gap-2">
                    <h1 class="text-lg">{{ $user->name }}</h1>
                </div>
                <p class="text-sm leading-3"> {{ $user->role->name }} <span>&#x2022</span> {{ $user->email }}</p>
            </div>
        </div>
        <div class="mt-4">
            <h1 class="font-bold">Status: 
                <span class="font-normal {{ $user->verification->verified ? 'text-green-500' : 'text-red-500' }}">
                    {{ $user->verification->verified ? 'Verified' : 'Unverified' }}
                </span>,
                <span class="font-normal {{ $user->restricted ? 'text-red-500' : 'text-green-500' }}">
                    {{ $user->restricted ? 'Restricted' : 'Unrestricted' }}
                </span>
            </h1>
            <div x-data="{open: false}" class="border border-gray-400 px-4 py-2 mt-2 rounded">
                <div class="flex justify-between">
                    <h1 class="font-bold">Verification:</h1>
                    <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open">
                        <x-bootstrap-icons icon="x" class="transition linear h-5" x-bind:class="open ? '' : 'rotate-45'" />
                    </span>
                </div>
                <div  x-show="open" x-collapse>
                    
                    <img class="mt-2 rounded shadow" src="{{ asset($user->verification->file->url) }}" alt="">
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <button wire:click='restrictUser' @class([
                "uppercase text-white px-4 py-2 rounded-md shadow text-sm font-bold transition",
                'bg-red-600 hover:bg-red-700' => ! $user->restricted,
                'bg-green-500 hover:bg-green-700' => $user->restricted
            ])>
                {{ $user->restricted ? 'Unrestrict' : 'Restrict' }}
            </button>
            <button wire:click.prevent='verifyUser' {{ $user->verification->verified ? 'disabled' : '' }} class=" uppercase bg-black text-white px-4 py-2 rounded-md shadow text-sm font-bold hover:bg-gray-700 disabled:bg-gray-700 transition">
                {{ $user->verification->verified ? 'verified' : 'verify' }}
            </button>
        </div>
    </div>
</div>
