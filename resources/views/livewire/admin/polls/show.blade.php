<?php

use function Livewire\Volt\{state, computed, mount};

use App\Models\PollOption;

state([
    'poll',
    'totalVote' => fn ($poll) => $poll->options->pluck('votes')->collapse()->count() 
]);

$percentage = computed(function (PollOption $option) {
    if ($this->totalVote > 0) {
        return round($option->votes->count() / $this->totalVote * 100, 2);
    }
    return 0;
});

?>

<div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 text-gray-900">
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
    </div>
</div>
