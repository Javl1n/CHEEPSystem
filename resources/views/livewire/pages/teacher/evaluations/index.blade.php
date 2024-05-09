<?php

use function Livewire\Volt\{state, layout, title};

use App\Models\EvaluationTaken;

layout('layouts.app');

state([
    'students' => EvaluationTaken::where('teacher_id', auth()->user()->id)->get()->pluck('student')
]);

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
                    <div class="mx-6 my-auto">
                        <x-text-input wire:model="search" wire:keyup="searchTeacher" placeholder="Search for Students..." class="block mt-1 w-full" type="text" name="name"/>
                    </div>
                </div>
                <div class="px-8 mt-2 mb-6">
                    @if($students->count() > 0)
                        <div class="grid grid-cols-5 gap-4">
                            @foreach ($students as $student)
                                <div @class([
                                        "border shadow rounded-lg hover:bg-gray-100 cursor-pointer py-4 transition",
                                    ])
                                    wire:click="selectTeacher({{ $student->id }})">
                                    <div>
                                        <x-profile-picture :src="asset($student->profile->url)" class="h-40 mx-auto" />
                                    </div>
                                    <div class="text-center mt-4 text-lg font-bold">{{ $student->name }}</div>
                                </div>
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
