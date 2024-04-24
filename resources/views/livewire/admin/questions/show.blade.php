<?php

use function Livewire\Volt\{state, mount};

state([
    'question',
]);

$editMode = fn () => $this->dispatch("editMode-" . $this->question->id);

$delete = function () {
    $this->dispatch("stateless-" . $this->question->id);
    // $this->question->delete();
    $this->redirect('/admin/evaluations', navigate: true);
    // $this->dispatch('refreshList');
};
?>


<div class="p-6 text-gray-900">
    <div class="my-4">
        <p class="text-xl">{{ $question->content }}</p>
    </div>
    <div class="flex items-center justify-end mt-4 gap-2">
        <x-danger-button wire:click.prevent='delete' class="" wire:confirm="Are you sure you want to delete this question?">
            {{ __('delete') }}
        </x-danger-button>
        <x-primary-button wire:click.prevent='editMode' class="">
            {{ __('edit') }}
        </x-primary-button>
    </div>
</div>

