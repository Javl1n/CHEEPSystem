<?php

use function Livewire\Volt\{state};

use App\Models\Subject;

state([
    'name',
    'code'
]);

$submit = function () {
    $this->validate([
        'name' => 'required',
        'code' => 'required|unique:App\Models\Subject,code',
    ]);
    Subject::create([
        'name' => $this->name,
        'code' => $this->code
    ]);

    $this->redirect('subjects', navigate: true);

};

?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between px-6 py-4">
        <div class=" text-gray-900 text-xl font-bold">
            {{ __("Add Subject") }}
        </div>
    </div>
    <div class="px-8 mt-2 mb-6">
        <div class="">
            <div class="flex gap-2 mt-1">
                <div class="flex flex-col">
                    <x-text-input wire:model="code" id="code" class="block" type="text" name="code" placeholder="Code" required />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>
                <div class="flex flex-col w-full">
                    <x-text-input wire:model="name" id="name" class="block" type="text" name="name" placeholder="Descriptive Title" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="flex flex-col">
                    <x-primary-button class="h-10" wire:click='submit'>
                        Submit
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>           
</div>
