<?php

use function Livewire\Volt\{state};

state([
    'question',
    'content' => fn ($question) => $question->content,
]);

$showMode = fn() => $this->dispatch("showMode-" . $this->question->id);

$save = function () {
    $this->validate([
        'content' => 'required|min:10',
    ]);

    $this->question->update([
        'content' => $this->content
    ]);

    // $this->redirect(request()->header('Referer'), navigate: true);
    $this->dispatch("showMode-" . $this->question->id);
};

?>

<div>
    <div class="p-6">
        <h1 class="font-bold text-gray-600 text-center">Edit Mode</h1>
        <div class="my-4">
            <textarea
                class="resize-none h-10 w-full py-2 text-xl   rounded 
                overflow-hidden
                {{-- border-transparent focus:border-transparent  focus:ring-0 --}}
                "
                x-data="{
                    resize: () => { $el.style.height = '10px'; $el.style.height = $el.scrollHeight + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model='content'
                placeholder=""
                x-transition
                required
            ></textarea>
            <x-input-error :messages="$errors->get('content')" class="" />
        </div>
        
        <div class="flex items-center justify-end mt-4 gap-2">
            <x-danger-button wire:click.prevent='showMode' class="">
                {{ __('cancel') }}
            </x-danger-button>
            <x-primary-button wire:click.stop='save' class="">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </div>
</div>
