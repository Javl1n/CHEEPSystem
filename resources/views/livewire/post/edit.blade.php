<?php

use function Livewire\Volt\{state};

state([
    'post',
    'content' => fn ($post) => $post->content 
]);

$showMode = fn() => $this->dispatch("showMode-" . $this->post->id);

$save = function() {
    $this->validate([
        'content' => 'required'
    ]);

    $this->post->update([
        'content' => $this->content
    ]);

    $this->dispatch("showMode-" . $this->post->id);
}

?>

<div class="my-4">
    <textarea
        class="resize-none h-10 w-full px-3 py-2 overflow-hidden text-lg rounded 
        {{-- border-transparent focus:border-transparent overflow-hidden focus:ring-0 --}}
        "
        x-data="{
            resize: () => { $el.style.height = '10px'; $el.style.height = $el.scrollHeight + 'px' }
        }"
        x-init="resize()"
        x-on:input="resize()"
        wire:model='content'
        x-transition
        required
    ></textarea>
    <x-input-error :messages="$errors->get('content')" class="" />
    <div class="mt-2 flex justify-end gap-2">
        <x-danger-button wire:click.prevent='showMode'>
            Cancel
        </x-primary-button>
        <x-primary-button wire:click.prevent='save'>
            Save
        </x-primary-button>
    </div>
</div>
