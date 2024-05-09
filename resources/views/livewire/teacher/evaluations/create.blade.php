<?php

use function Livewire\Volt\{state, mount};

use Illuminate\Database\Eloquent\Builder;

use App\Models\User;
use App\Models\Subject;


state([
    'students' => User::where('role_id', 3)->whereDoesntHave('studentEvaluations', function (Builder $query) {
        $query->where('teacher_id', auth()->user()->id);
    })->get(),
    'subjects' => Subject::all(),
    'selectedSubject',
    'selectedStudents' => collect([0]),
]);

mount(function () {
    $this->subject = $this->subjects->first();
});

$toggleStudent = function ($student) {
    if($this->selectedStudents->search($student)) {
        $this->selectedStudents = $this->selectedStudents->reject(function ($value, $key) use ($student) {
            return $value === $student;
        });
    } else {
        if($this->selectedStudents->search(0)){
            $this->selectedStudents = $this->selectedStudents->reject(function ($value, $key) use ($student) {
            return $value === 0;
        });
        }
        $this->selectedStudents = $this->selectedStudents->push($student);
    }
};

$save = function () {
    if($this->selectedSubject === null) {
        return;
    }
    $this->selectedStudents->map(function ($item, $key) {
        if($item === 0) {
            return;
        }
        auth()->user()->teacherEvaluations()->create([
            'subject_id' => $this->selectedSubject,
            'student_id' => $item
        ]);
    });
    $this->redirect(request()->header('Referer'), navigate: true);
}

?>

<div x-data="{ open: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between px-6 py-4">
        <div class=" text-gray-900 text-xl font-bold">
            {{ __("Add Students") }}
        </div>
        <span x-on:click="open = ! open " class="my-auto">
            <x-bootstrap-icons icon="x" x-bind:class="open ? '' : 'rotate-45'" class="h-6 w-6 linear transition cursor-pointer" />
        </span>
        {{-- <div class="mx-6 my-auto">
            <x-text-input wire:model="search" wire:keyup="searchTeacher" placeholder="Search for Students..." class="block mt-1 w-full" type="text" name="name"/>
        </div> --}}
    </div>
    <div x-show="open" class="px-8 mt-2 mb-6" x-collapse>
        <div class="flex justify-between">
            <div class="flex gap-2">
                <span class="text-sm my-auto">Subject :</span>
                <select class="text-sm my-auto py-0 h-8 rounded-lg" wire:model='selectedSubject'>
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="my-auto">
                <x-text-input wire:model="search" wire:keyup="searchStudents" placeholder="Search for Students..." class="block mt-1 w-full" type="text" name="name"/>
            </div>
        </div>
        <div class="grid grid-cols-5 gap-4 mt-4">
            @foreach ($students as $student)
                {{-- @if (empty($this->student) || $this->student->id === $student->id) --}}
                    <div @class([
                            "border shadow rounded-lg hover:bg-gray-100 cursor-pointer py-4 transition",
                            "bg-gray-100" => $this->selectedStudents->search($student->id)
                        ])
                        wire:click="toggleStudent({{ $student->id }})">
                        <div>
                            <x-profile-picture :src="asset($student->profile->url)" class="h-40 mx-auto" />
                        </div>
                        <div class="text-center mt-4 text-lg font-bold">{{ $student->name }}</div>
                    </div>
                {{-- @endif --}}
            @endforeach
        </div>
        <div class="flex justify-center">
            <x-primary-button class="mt-5" wire:click.prevent='save'>
                Save
            </x-primary-button>
        </div>
    </div>           
</div>
