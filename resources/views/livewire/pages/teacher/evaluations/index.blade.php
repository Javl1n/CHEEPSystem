<?php

use function Livewire\Volt\{state, layout, title, mount};

use App\Models\EvaluationTaken;

layout('layouts.app');

state([
    'evaluations' => EvaluationTaken::where('teacher_id', auth()->user()->id)->with([
        'student' => [
            'profile'
        ],
        'subject'
    ])->get(),
    'studentCount',
    'subjects',
]);

mount(function () {
    $this->studentCount = $this->evaluations->pluck('student')->count();
    $this->subjects = $this->evaluations->pluck('subject')->groupBy('code');
});

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluations') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('teacher.evaluations.create')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="flex justify-between">
                    <div class="p-6 text-gray-900 text-xl font-bold">
                        {{ __("Your Students: ") }}
                    </div>
                </div>
                <div class="px-8 mt-2 mb-6">
                    @if($studentCount > 0)
                        <div class="grid grid-cols-5 gap-4">
                            @foreach ($subjects as $subject)
                                <div class="col-span-5 border-b text-lg font-bold">
                                    {{ $subject->first()->code }} - {{ $subject->first()->name }}:
                                </div>
                                @foreach ($evaluations->where('subject_id', $subject->first()->id)->pluck('student') as $student)
                                    <div class="">
                                        @php
                                            $evaluation = $this->evaluations->where('student_id', $student->id)->first();
                                        @endphp
                                        <div @class([
                                                "shadow-md border rounded-lg py-4",
                                                "hover:bg-gray-100 cursor-pointer transition shadow-red-500/50" => ! $evaluation->answered,
                                                "shadow-green-400/50" => $evaluation->answered
                                            ])
                                            @if ( ! $evaluation->answered)
                                                wire:click="$dispatch('open-modal', 'edit-evaluation-{{ $evaluation->id }}')"
                                            @endif
                                            >
                                            <div>
                                                <x-profile-picture :src="asset($student->profile->url)" class="h-40 mx-auto" />
                                            </div>
                                            <div class="text-center mt-4 text-lg font-bold">{{ $student->name }}</div>
                                        </div>
                                        @livewire('teacher.evaluations.edit', ['evaluation' => $evaluation])
                                    </div>
                                @endforeach
                            @endforeach
                            
                        </div>
                    @else
                        <h1 class="text-center font-bold text-gray-500 w-full">You have no Students</h1>
                    @endif
                </div> 
            </div>
        </div>
    </div>
</div>
