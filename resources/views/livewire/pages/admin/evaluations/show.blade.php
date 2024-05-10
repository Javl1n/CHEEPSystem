<?php

use function Livewire\Volt\{state, layout, mount, computed};

use App\Models\User;
use App\Models\EvaluationQuestion;
use App\Models\Subject;

layout('layouts.app');

state([
    'teacher',
    'studentCount',
    'answers',
    'questions',
    'subjects',
    'shownSubject' => 0
]);

mount(function () {
    $this->teacher = User::where('id', $this->teacher)->with([
        'teacherEvaluations' => [
            'scores',
            'subject'
        ]
    ])->first();
    $this->studentCount = $this->teacher->teacherEvaluations;
    $this->answers = $this->studentCount->pluck('scores')->collapse();
    $this->questions = EvaluationQuestion::all();
    $this->subjects = $this->studentCount->pluck('subject')->groupBy('code');
});

$percentage = computed(function (int $question, int $count) {
    $answersOfQuestion = $this->answers->where('question_id', $question);
    $totalAnswers = $answersOfQuestion->count();
    $whoAnsweredCount = $answersOfQuestion->where('score', $count)->count();
    if($totalAnswers > 0) {
        return round($whoAnsweredCount / $totalAnswers * 100, 2);
    }
    return 0;
});

$totalPercentage = computed(function () {
    $totalAnswers = $this->answers->pluck('score');
    if($totalAnswers->count() > 0) {
        return round($totalAnswers->sum() / ($totalAnswers->count() * 5) * 100, 2);
    }
    return 0;
});

$showSubject = function ($subjectId) {
    $this->shownSubject = $subjectId;

    if ($this->shownSubject !== 0) {
        $this->studentCount = $this->teacher->teacherEvaluations->where('subject_id', $this->shownSubject);
        $this->answers = $this->studentCount->pluck('scores')->collapse();
    } else {
        $this->studentCount = $this->teacher->teacherEvaluations;
        $this->answers = $this->studentCount->pluck('scores')->collapse();
    }
}

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluation of ' . $this->teacher->name) }}
        </h2>
    </x-slot>
    <div class="py-12 px-6 lg:px-8 max-w-4xl mx-auto">
        {{-- <div class="border-b-2">
        </div> --}}
        <div class="overflow-hidden shadow-sm sm:rounded-lg"
        style="
            background-image: linear-gradient(to right, #fee2e2 {{ $this->totalPercentage }}%, white 0%);
            border-width: 1px;
        "
        >
            <div class="p-6 text-gray-900 text-3xl font-bold">
                <div class="">Percentage: {{ $this->totalPercentage }}%</div>
                <div class="text-sm mt-2 text-gray-500">Evaluated : {{ $studentCount->where('answered', true)->count() }} out of {{ $studentCount->count() }}</div>
            </div>
        </div>
        <div class="mt-4 overflow-x-hidden">
            <div 
            wire:click='showSubject(0)'
            @class([
                "inline-block p-2 rounded sm:rounded-lg text-sm font-bold  transition linear",
                "bg-red-500 text-white shadow-sm" => $shownSubject === 0,
                "bg-white text-black shadow-sm cursor-pointer" => $shownSubject !== 0
            ])>
                All Subjects
            </div>
            @foreach ($subjects as $subject)
                <div
                wire:key='subject-{{ $subject->first()->id }}' 
                wire:click='showSubject({{ $subject->first()->id }})'
                @class([
                    "inline-block p-2 mb-1 rounded sm:rounded-lg  text-sm font-bold transition linear",
                    "bg-red-500 text-white shadow-sm" => $shownSubject === $subject->first()->id,
                    "bg-white text-black shadow-sm cursor-pointer" => $shownSubject !== $subject->first()->id,
                ])>
                    {{ $subject->first()->code }}
                </div>
            @endforeach
        </div>
        @foreach ($questions as $question)
            <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4" wire:key='question-{{ $question->id }}'>
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold">{{ $question->content }}</h1>
                    <div class="mt-4">
                        @for ($count = 1; $count < 6; $count++)
                            <div
                            wire:key='question-{{ $question->id }}-{{ $count }}'
                            class="px-2 py-2 text-lg font-bold mt-2"
                            style="
                                background-image: linear-gradient(to right, #fee2e2 {{ $this->percentage($question->id, $count) }}%, white 0%);
                                border-width: 1px;
                            ">
                                {{ $count }} - {{ $this->percentage($question->id, $count) }}%
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
