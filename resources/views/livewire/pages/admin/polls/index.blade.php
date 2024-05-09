<?php

use function Livewire\Volt\{state, layout, mount};

layout('layouts.app');

state([
    'poll'
]);

mount(function () {
    $this->poll = App\Models\Feature::where('id', 2)->first();
});

$togglePolling = fn () => $this->poll->update(['enabled' => !$this->poll->enabled]);

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Polls') }}
        </h2>
    </x-slot>
    <button 
        x-transition 
        x-data="{mouseover: false}" 
        x-on:mouseenter="mouseover = true" 
        x-on:mouseleave="mouseover = false" 
        wire:click="togglePolling"
        @class([
            'absolute top-20 right-12 p-2 text-sm rounded w-40 font-bold transition linear',
            'border border-green-400 text-green-600 hover:bg-green-200' => !$this->poll->enabled,
            'bg-green-600 text-white hover:bg-red-500' => $this->poll->enabled
        ]) 
        x-text="mouseover ? '{{ $poll->enabled ? 'Stop Polling' : 'Start Polling' }}' : '{{ $poll->enabled ? 'Polling Ongoing ' : 'Start Polling' }}'"> 
    </button>
    
</div>
