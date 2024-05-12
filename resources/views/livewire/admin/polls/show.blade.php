<?php

use function Livewire\Volt\{state, computed, mount};

use App\Models\PollOption;

state([
    'poll',
    'count',
    'totalVote' => fn ($poll) => $poll->options->pluck('votes')->collapse()->count(),
]);

$percentage = computed(function (PollOption $option) {
    if ($this->totalVote > 0) {
        return round($option->votes->count() / $this->totalVote * 100, 2);
    }
    return 0;
});



?>

<div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="pb-6 px-6 pt-4 text-gray-900">
        <div class="flex justify-end">
            <x-dropdown align="right" width="24">
                <x-slot name="trigger">
                    <button class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <x-bootstrap-icons icon="three-dots" class="h-5" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link x-on:click.prevent="$dispatch.">
                        {{ __('Edit') }}
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent='delete' wire:confirm="Are you sure you want to delete this post?">
                        {{ __('Delete') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
        <h1 class="text-xl font-bold">{{ $poll->description }}</h1>
        <div class="mt-4">
            @foreach ($poll->options as $option)
                <div
                wire:key='option-{{ $option->id }}'
                class="px-2 py-2 text-lg font-bold mt-2"
                style="
                    background-image: linear-gradient(to right, #fee2e2 {{ $this->percentage($option) }}%, white 0%);
                    border-width: 1px;
                ">
                    {{ $option->description }} - {{ $this->percentage($option) }}%
                </div>
            @endforeach
        </div>
        <div class="mt-4 text-sm font-bold text-gray-500">
            {{ $totalVote }} out of {{ $count }} students voted.
        </div>
    </div>
    @livewire('admin.polls.edit')
</div>
