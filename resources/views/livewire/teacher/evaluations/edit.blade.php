<?php

use function Livewire\Volt\{state};

use App\Models\Subject;

state([
    'evaluation',
    'subjects' => fn () => Subject::whereNot('subject_id', $this->evaluation->subject->id)->get(),
    'selectedSubject' => 0
]);

$save = function () {
    if($this->selectedSubject === 0) {
        return;
    }

    $this->evaluation->update([
        'subject_id' => $this->selectedSubject
    ]);

    $this->redirect(request()->header('Referer'), navigate: true);
};

$remove = function () {
    $this->evaluation->delete();
    
    $this->redirect(request()->header('Referer'), navigate: true);
};

?>

<x-modal maxWidth="xl" name="edit-evaluation-{{ $this->evaluation->id }}" :show="$errors->isNotEmpty()" focusable>
    <div wire:submit="deleteUser" class="p-6">

        <h2 class="text-lg font-medium text-gray-900">
            {{ $this->evaluation->student->name }}
        </h2>

        <div class="mt-6">
            Current Subject:
            <span class="font-bold">{{ $evaluation->subject->code }} - {{ $evaluation->subject->name }}</span>
        </div>
        <div class="flex gap-2 mt-6">
            <div class="flex flex-col w-20 my-auto">
                Change to: 
            </div>
            <div class="flex-1 flex flex-col">
                <select class="text-sm my-auto py-0 h-8 rounded-lg max-w-96" wire:model='selectedSubject'>
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <x-danger-button class="" wire:click='remove'>
                {{ __('Remove Student') }}
            </x-danger-button>

            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="h-10" wire:click='save'>
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>