<?php

use function Livewire\Volt\{state};
use App\Models\EvaluationQuestion;

state([
    'content'
]);

$save = function () {
    $this->validate([
        'content' => 'required|min:10'
    ]);

    EvaluationQuestion::create([
        'content' => $this->content
    ]);

    $this->redirect('/admin/evaluations', navigate: true);
}

?>

<div class="bg-white mb-6 overflow-hidden shadow-sm sm:rounded-lg" x-data="{open: true}">
    <div class="text-gray-900">
        <div class="p-6 flex justify-between border-b shadow-sm">
            <h1 class="font-bold">
                {{ __("Add Question") }}
            </h1>
            <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open">
                <x-bootstrap-icons icon="x" class="transition linear h-5" x-bind:class="open ? '' : 'rotate-45'" />
            </span>
        </div>

        <div x-show="open" class="p-6" x-transition x-collapse>
            <div class="">
                <textarea
                    class="resize-none h-10 w-full p-0 text-lg rounded 
                    border-transparent focus:border-transparent overflow-hidden focus:ring-0
                    "
                    x-data="{
                        resize: () => { $el.style.height = '10px'; $el.style.height = $el.scrollHeight + 'px' }
                    }"
                    x-init="resize()"
                    x-on:input="resize()"
                    wire:model='content'
                    placeholder="Question Here..."
                    x-transition
                    required
                ></textarea>
                <x-input-error :messages="$errors->get('content')" class="" />
            </div>
            
            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
    
                <x-primary-button wire:click.prevent='save' class="ms-3">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
