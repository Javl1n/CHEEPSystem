<?php

use function Livewire\Volt\{state, layout, title};

layout('layouts.app');

?>

<div class="overflow-auto">
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluations') }}
            </h2>
            {{-- <button>
                Enable Evaluation
            </button> --}}
        </div>
    </x-slot>
    <div class="grid lg:grid-cols-6 gap-8 py-12 px-6 lg:px-8">
        <div class="col-start-2 col-span-4">
            @livewire('admin.evaluations.create')
            @livewire('admin.evaluations.show')
        </div>
        {{-- <div class="col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Profile") }}
                </div>
            </div>
        </div> --}}
    </div>
</div>
