<?php

use function Livewire\Volt\{state, layout, boot};
use App\Models\EvaluationQuestion;
use App\Models\Feature;


layout('layouts.app');

state([
    'questions',
    'evaluation',
]);

boot(function () {
    $this->questions = EvaluationQuestion::latest()->get();
    $this->evaluation = Feature::where('id', 1)->first();
});

$toggleEvaluation = fn () => $this->evaluation->update(['enabled' => !$this->evaluation->enabled]);

?>

<div class="">
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluations') }}
            </h2>
        </div>
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
    <div class="grid lg:grid-cols-12 gap-8">
        <div class="col-span-5 py-12 ps-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @livewire('admin.evaluations.select-teachers')
                </div>
            </div>
        </div>
        <div class="col-span-7 h-[calc(100vh-64px-64px)] py-12 pe-8 overflow-auto">
            @livewire('admin.questions.create')
            @foreach ($questions as $question)
                @livewire('admin.questions.index', ['question' => $question, 'loop' => $loop])
            @endforeach
        </div>
    </div>
</div>
