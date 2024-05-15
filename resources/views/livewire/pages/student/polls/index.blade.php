<?php

use function Livewire\Volt\{state, layout, mount};

use App\Models\Feature;

layout('layouts.app');

state([
    'polls',
    'answered',
    'enabled' => Feature::where('id', 2)->first()->enabled
]);

mount(function () {
    $this->polls = App\Models\Poll::with('options.votes')->latest()->get();
    $this->answered = auth()->user()->studentVotes->count() > 0;
});

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Polls') }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto py-12 px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm shadow-red-400 sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                @if ($enabled)
                    <h1 class="text-xl font-bold">Voting is still on going</h1>
                @else
                    <h1 class="text-xl font-bold">Voting has ended  </h1>
                @endif
                @if($enabled)
                    @if ($answered)
                        <h1 class="text-sm">Wait for the voting to end to see the final results</h1>
                    @else
                        <h1 class="text-sm">Vote first to see the current standings</h1>
                    @endif
                @else
                    <h1 class="text-sm">Below are the final standings</h1>                        
                @endif
            </div>
        </div>
        <div class="">
            @if (!$answered && $enabled)
                @livewire('student.polls.form', ['polls' => $polls])
            @else
                @if(!$enabled)
                    @foreach ($polls as $poll)
                        @livewire('student.polls.show', ['poll' => $poll], key('poll-show-' . $poll->id))
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>
