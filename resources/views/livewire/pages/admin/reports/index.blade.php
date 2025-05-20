<?php

use function Livewire\Volt\{state, layout};
use App\Models\User;
use App\Models\Report;

state([
    'reports' => Report::with(['message'])->where('restricted', false)->get()
]);

layout('layouts.app');

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Message Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 lg:px-8 max-w-5xl mx-auto">
        <div class="col-span-2">
            {{-- @livewire('post.create') --}}
            @foreach ($this->reports as $report)
                <div class="{{ $loop->first ? '' : 'mt-4' }}">
                    @livewire('admin.reports.show', ['report' => $report])
                </div>
            @endforeach
            @if ($this->reports->count() < 1)
                <div class="flex gap-4">
                    <div class="border-t-2 border-gray-400 my-auto flex-1"></div>
                    <div class="font-bold text-gray-500">No active reports yet</div>
                    <div class="border-t-2 border-gray-400 my-auto flex-1"></div>
                </div>
            @endif
        </div>
        {{-- <div class="col-span-1">
            @livewire('users.navigate')
        </div> --}}
    </div>
</div>
