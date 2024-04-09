<?php

use function Livewire\Volt\{rules, state, usesFileUploads };
use Illuminate\Validation\Rules;
use App\Models\User;

usesFileUploads();

state([
    'contentInput', 
    'photo',
    'withPhoto' => false
]);

$togglePhoto = function () {
    $this->withPhoto = !$this->withPhoto;
    $this->photo = '';
};

$uploadPost = function () {
    $this->validate([
        'contentInput' => 'required',
    ]);
    $post = auth()->user()->posts()->create([
        'content' => $this->contentInput
    ]);

    if($this->withPhoto) {
        $this->validate([
            'photo' => 'image',
        ]);
        $post->file()->create([
            'url' => $this->photo->store('images/posts')
        ]);
    }

    $this->redirect('posts', navigate: true);

};

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
            <div class="flex gap-2">
                <x-profile-picture class="h-12 w-12 shadow" src="{{ asset(auth()->user()->profile->url) }}" />

                <div class="flex-1">
                    <div class="flex justify-between gap-2">
                        <h1 class="text-lg font-bold">{{ auth()->user()->name }}</h1>
                    </div>
                    <p class="text-xs leading-3">
                        {{-- {{ auth()->user()->email }} &#x2022  --}}
                        {{ auth()->user()->role->name }}
                    </p>
                </div>
            </div>
            <div class="mb-10 mt-6">
                <textarea
                    class="resize-none h-10 w-full p-0 text-lg rounded border-transparent focus:border-transparent overflow-hidden focus:ring-0"
                    x-data="{
                        resize: () => { $el.style.height = '10px'; $el.style.height = $el.scrollHeight + 'px' }
                    }"
                    x-init="resize()"
                    x-on:input="resize()"
                    wire:model='contentInput'
                    placeholder="What's on your mind, {{ strtok(auth()->user()->name, " ") }}?"
                    x-transition
                    required
                ></textarea>
                <x-input-error :messages="$errors->get('contentInput')" class="" />
            </div>
            @if ($this->withPhoto)
                <x-image-upload model="photo" />
            @endif
            <div class="mt-4 border-2 rounded-md flex justify-between p-4">
                <h1 class="text-sm font-bold p-2">Add to your post</h1>
                <div class="flex gap-2">
                    <div class="rounded-full hover:bg-gray-100 p-2 transition cursor-pointer fill-black hover:fill-red-500" x-on:click="$wire.togglePhoto">
                        <x-bootstrap-icons icon="photo" class="h-5 " />
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
    
                <x-primary-button wire:click.prevent='uploadPost' class="ms-3">
                    {{ __('Post') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
