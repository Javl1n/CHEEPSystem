<?php

use function Livewire\Volt\{state, layout};

use App\Models\Subject;

layout('layouts.app');

state([
    'subjects' => Subject::all()
])

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects for Evaluation') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.subjects.create')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="flex justify-between">
                    <div class="p-6 text-gray-900 text-xl font-bold">
                        {{ __("Subjects: ") }}
                    </div>
                </div>
                <div class="px-8 mt-2 mb-6">
                    @if($subjects->count() > 0)
                        <div class="grid grid-cols-5 gap-4">
                            @foreach ($subjects as $subject)
                                @livewire('admin.subjects.show', ['subject' => $subject])
                            @endforeach
                        </div>
                    @else
                        <h1 class="text-center font-bold text-gray-500 w-full">No Subjects Yet</h1>
                    @endif
                </div> 
            </div>
        </div>
    </div>
</div>
