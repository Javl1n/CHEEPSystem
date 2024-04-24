<?php

use function Livewire\Volt\{state, layout, mount};
use App\Models\User;
use App\Models\EvaluationQuestion;

layout('layouts.app');

state([
    'teacher',
    'questions' => EvaluationQuestion::all(),
    'answers'
]);

mount(function () {
    $this->teacher = User::where('id', $this->teacher)->first(); 
    foreach ($this->questions as $question) {
        $this->answers[$question->id] = 0;
    }
});

$selectAnswer = function ($question, $answer) {
    $this->answers[$question] = $answer;
};

$save = function () {
    $this->validate([
        'answers.*' => 'gt:0|lt:6'
    ]);

    $evaluation = auth()->user()->studentEvaluations()->create([
        'teacher_id' => $this->teacher->id
    ]);

    foreach ($this->answers as $key => $value) {
        if($value > 0 && $value < 6) {
            $evaluation->scores()->create([
                'question_id' => $key,
                'score' => $value
            ]);
        }
    }
    
    $this->redirect(route('posts.index'), navigate: true);
};

?>

<div class="overflow-auto">
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluation for ' . $teacher->name ) }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mt-2 mx-auto sm:px-6 lg:px-8">
            @foreach ($questions as $question)
                <div @class([
                        "bg-white overflow-hidden shadow-sm sm:rounded-lg w-full p-6",
                        "mt-6" => !$loop->first
                    ])>
                    <div class=" text-gray-900 text-lg font-bold text-center">
                        {{ $question->content }}
                    </div>
                    <div class="flex justify-center gap-10 mt-5">
                        <div class="w-40 my-auto font-bold text-md text-end text-red-500">Disagree</div>
                        <div class="flex gap-7">
                            {{-- <input type="range" min="1" max="5" class="w-2/3 accent-red-500 h-10"> --}}
                            <div 
                                @class([
                                    "mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer h-10 w-10",
                                    " border-2 border-red-500 hover:bg-red-300" => $answers[$question->id] !== 1,
                                    "bg-red-500" => $answers[$question->id] === 1
                                ])
                                wire:click="selectAnswer({{ $question->id }}, {{ 1 }})"
                            ></div>
                            <div 
                                @class([
                                    "mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer h-8 w-8",
                                    "border-2 border-red-500 hover:bg-red-300" => $answers[$question->id] !== 2,
                                    "bg-red-500" => $answers[$question->id] === 2
                                ])
                                wire:click="selectAnswer({{ $question->id }}, {{ 2 }})"
                            ></div>
                            <div 
                                @class([
                                    "mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer h-5 w-5",
                                    "border-2 border-gray-500 hover:bg-gray-300" => $answers[$question->id] !== 3,
                                    "bg-gray-500" => $answers[$question->id] === 3
                                ])
                                wire:click="selectAnswer({{ $question->id }}, {{ 3 }})"
                            ></div>
                            <div 
                                @class([
                                    "mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer h-8 w-8",
                                    "border-2 border-green-500 hover:bg-green-300" => $answers[$question->id] !== 4,
                                    "bg-green-500" => $answers[$question->id] === 4
                                ])
                                wire:click="selectAnswer({{ $question->id }}, {{ 4 }})"
                            ></div>
                            <div 
                                @class([
                                    "mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer h-10 w-10",
                                    "border-2 border-green-500 hover:bg-green-300" => $answers[$question->id] !== 5,
                                    "bg-green-500" => $answers[$question->id] === 5
                                ])
                                wire:click="selectAnswer({{ $question->id }}, {{ 5 }})"
                            ></div>
                        </div>
                        <div class="w-40 my-auto font-bold text-lg text-start text-green-500">Agree</div>
                    </div>
                    <div class="flex justify-center">
                        @error('answers.' . $question->id)
                            <x-input-error messages="Field must be required" class="mt-2" />
                        @enderror
                    </div>
                </div>
            @endforeach
            <div class="flex mt-6 justify-end gap-4">
                @error('answers.*')
                    <x-input-error messages="All fields must be required" class="mt-2" />
                @enderror
                <x-danger-button wire:click.prevent='returnToSelection'>
                    Go Back
                </x-danger-button>

                <x-primary-button wire:click.prevent='save'>
                    Submit
                </x-primary-button>
                
            </div>
        </div>
    </div>
</div>
