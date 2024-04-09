<?php

use function Livewire\Volt\{state};

state(['contentInput'])

?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{open: true}">
    <div class="text-gray-900">
        <div class="p-6 flex justify-between border-b shadow-sm">
            <h1 class="font-bold">
                {{ __("Add Post") }}
            </h1>
            <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open" x-text="open ? 'close' : 'open'">
                
            </span>
        </div>

        <div x-show="open" class="p-6" x-transition x-collapse>
            
            <textarea
            class="resize-none h-10 w-full p-0 text-lg rounded border-transparent focus:border-transparent overflow-hidden focus:ring-0"
             
            x-data="{
                resize: () => { $el.style.height = '10px'; $el.style.height = $el.scrollHeight + 'px' }
            }"
            x-init="resize()"
            x-on:input="resize()"
            wire:model='contentInput'
            placeholder="What's on your mind?"
            x-transition
            ></textarea>
            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
    
                <x-primary-button class="ms-3">
                    {{ __('Post') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
