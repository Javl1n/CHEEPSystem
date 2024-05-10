<?php

use function Livewire\Volt\{state, layout, mount};

layout('layouts.app');

state([
    'polls',
    'answered'
]);

mount(function () {
    $this->polls = App\Models\Poll::latest()->get();
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
                <h1 class="text-xl font-bold">Polls are still on going</h1>
                @if($answered)
                    <h1 class="text-sm">Below are the current standings</h1>
                @else
                    <h1 class="text-sm">Vote first to see the current standings</h1>
                @endif
            </div>
        </div>
        <div class="">
            @if ($answered)
                @foreach ($polls as $poll)
                    @livewire('student.polls.show', ['poll' => $poll], key('poll-show-' . $poll->id))
                @endforeach
            @else
                @livewire('student.polls.form', ['polls' => $polls])
            @endif
        </div>
    </div>
</div>
