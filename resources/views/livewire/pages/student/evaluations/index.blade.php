<?php

use function Livewire\Volt\{state, mount, layout};

use App\Models\EvaluationTaken;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;

layout('layouts.app');

state([
    'teachers' => EvaluationTaken::where('student_id', auth()->user()->id)
                        ->where('answered', false)
                        ->get()->pluck('teacher'),
    'search' => "",
    'teacher',
]);

$searchTeacher = function () {
    if($this->search === "") {
        $this->teachers = User::where('role_id', 2)->whereHas('verification', function (Builder $query) {
            $query->where('verified', true);
        })->whereDoesntHave('teacherEvaluations', function (Builder $query) {
            $query->where('student_id', auth()->user()->id);
        })->get();
    } else {
        $this->teachers = User::where('role_id', 2)->whereHas('verification', function (Builder $query) {
            $query->where('verified', true);
        })->whereDoesntHave('teacherEvaluations', function (Builder $query) {
            $query->where('student_id', auth()->user()->id);
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
};

$selectTeacher = function ($teacher) {
    $this->teacher = EvaluationTaken::where("teacher_id", $teacher)->first();
    $this->redirect(route('student.evaluations.show', ['teacher' => $this->teacher]), navigate: true);
};

?>

<div class="overflow-auto">
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Evaluations') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between">
                    <div class="p-6 text-gray-900 text-xl font-bold">
                        {{ __("Select a teacher to evaluate: ") }}
                    </div>
                    <div class="mx-6 my-auto">
                        <x-text-input wire:model="search" wire:keyup="searchTeacher" placeholder="Search for Teachers..." class="block mt-1 w-full" type="text" name="name"/>
                    </div>
                </div>
                <div class="grid grid-cols-5 px-8 mt-2 mb-6 gap-4">
                    @foreach ($teachers as $teacher)
                        {{-- @if (empty($this->teacher) || $this->teacher->id === $teacher->id) --}}
                            <div @class([
                                    "border shadow rounded-lg hover:bg-gray-100 cursor-pointer py-4 transition",
                                ]) 
                                wire:click="selectTeacher({{ $teacher->id }})">
                                <div>
                                    <x-profile-picture :src="asset($teacher->profile->url)" class="h-40 mx-auto" />
                                </div>
                                <div class="text-center mt-4 text-lg font-bold">{{ $teacher->name }}</div>
                            </div>
                        {{-- @endif --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
