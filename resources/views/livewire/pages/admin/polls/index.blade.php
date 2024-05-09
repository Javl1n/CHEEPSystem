<?php

use function Livewire\Volt\{state, layout};

layout('layouts.app');

state();

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
        wire:click="toggleEvaluation"
        @class([
            'absolute top-20 right-12 p-2 text-sm rounded w-40 font-bold transition linear',
            'border border-green-400 text-green-600 hover:bg-green-200' => !$this->evaluation->enabled,
            'bg-green-600 text-white hover:bg-red-500' => $this->evaluation->enabled
        ]) 
        x-text="mouseover ? '{{ $evaluation->enabled ? 'Stop Evaluation' : 'Start Evaluation' }}' : '{{ $evaluation->enabled ? 'Evaluation Ongoing ' : 'Start Evaluation' }}'"> 
    </button>
</div>
