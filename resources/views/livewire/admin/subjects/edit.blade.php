<?php

use function Livewire\Volt\{state};

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

state([
    'subject',
    'name' => fn ($subject) => $subject->name,
    'code' => fn ($subject) => $subject->code
]);

$save = function () {
    $this->validate([
        'name' => 'required',
        'code' => [
            'required',
            Rule::unique('subjects')->ignore($this->subject->id),
        ]
    ]);

    $this->subject->update([
        'name' => $this->name,
        'code' => $this->code
    ]);

    $this->redirect(request()->header('Referer'), navigate: true);
};

?>

<x-modal name="edit-subject-{{ $subject->id }}" :show="$errors->isNotEmpty()" focusable>
    <div wire:submit="deleteUser" class="p-6">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Subject') }}
        </h2>

        <div class="flex gap-2 mt-6">
            <div class="flex flex-col w-20">
                <x-text-input wire:model="code" id="code" class="block" type="text" name="code" placeholder="Code" required />
                <x-input-error :messages="$errors->get('code')" class="mt-2 break-words text-center" />
            </div>
            <div class="flex-1 flex flex-col w-full">
                <x-text-input wire:model="name" id="name" class="block w-full" type="text" name="name" placeholder="Descriptive Title" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="flex flex-col">
                
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <x-danger-button class="">
                {{ __('Delete') }}
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
