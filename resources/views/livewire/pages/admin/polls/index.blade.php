<?php

use function Livewire\Volt\{state, layout, mount};

layout('layouts.app');

state([
    'pollFeature',
    'polls'
]);

mount(function () {
    $this->pollFeature = App\Models\Feature::where('id', 2)->first();
    $this->polls = App\Models\Poll::latest()->get();
});

$togglePolling = fn () => $this->pollFeature->update(['enabled' => !$this->pollFeature->enabled]);

?>

<div class="overflow-auto">
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
            'border border-green-400 text-green-600 hover:bg-green-200' => !$this->pollFeature->enabled,
            'bg-green-600 text-white hover:bg-red-500' => $this->pollFeature->enabled
        ]) 
        x-text="mouseover ? '{{ $pollFeature->enabled ? 'Stop Polling' : 'Start Polling' }}' : '{{ $pollFeature->enabled ? 'Polling Ongoing ' : 'Start Polling' }}'"> 
    </button>
    <div class="max-w-4xl mx-auto py-12 px-6 lg:px-8">
        <div class="">
            @if(! $pollFeature->enabled)
                @livewire('admin.polls.create')
            @endif
            @foreach ($polls as $poll)
                @livewire('admin.polls.show', ['poll' => $poll], key('poll-' . $poll->id))
            @endforeach
        </div>
    </div>
</div>
