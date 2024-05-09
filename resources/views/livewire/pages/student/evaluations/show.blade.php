<?php

use function Livewire\Volt\{state, layout, mount};
use App\Models\User;
use App\Models\EvaluationQuestion;
use App\Models\EvaluationTaken;

layout('layouts.app');

state([
    'teacher',
    'evaluation',
    'questions' => EvaluationQuestion::all(),
    'answers'
]);

mount(function () {
    $this->evaluation = EvaluationTaken::where('id', $this->teacher)->first();
    $this->teacher = $this->evaluation->teacher; 
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

    foreach ($this->answers as $key => $value) {
        if($value > 0 && $value < 6) {
            $this->evaluation->scores()->create([
                'question_id' => $key,
                'score' => $value
            ]);
        }
    }
    
    $this->evaluation->update([
        'answered' => true
    ]);
    
    $this->redirect(route('students.evaluation.index'), navigate: true);
};

?>

<div class="overflow-auto">
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluation for ' . $teacher->name ) }}
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subject: ' . $evaluation->subject->name ) }}
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
                            @for ($i = 1; $i < 6; $i++)
                                <div 
                                    @class([
                                        "flex flex-col justify-center font-bold mx-auto my-auto text-center rounded-full transition duration-150 cursor-pointer",
                                        "h-10 w-10" => $i === 1 || $i === 5,
                                        "h-8 w-8 text-sm" => $i === 2 || $i === 4,
                                        "h-5 w-5 text-xs" => $i === 3,
                                        "border-2 border-green-500 hover:bg-green-300 text-green-500" => $answers[$question->id] !== $i && $i > 3,
                                        "bg-green-500 text-white" => $answers[$question->id] === $i && $i > 3,
                                        "border-2 border-gray-500 hover:bg-gray-300 text-gray-500" => $answers[$question->id] !== $i && $i === 3,
                                        "bg-gray-500 text-white" => $answers[$question->id] === $i && $i === 3,
                                        "border-2 border-red-500 hover:bg-red-300 text-red-500" => $answers[$question->id] !== $i && $i < 3,
                                        "bg-red-500 text-white" => $answers[$question->id] === $i && $i < 3
                                    ])
                                    wire:click="selectAnswer({{ $question->id }}, {{ $i }})"
                                >{{ $i }}</div>
                            @endfor
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
