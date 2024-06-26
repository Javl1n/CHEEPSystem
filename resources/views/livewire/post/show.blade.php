<?php

use function Livewire\Volt\{state, on};
use Carbon\CarbonInterface;

state([
    'post',
    'loop',
    'state' => 'show'
]);

on([
    "editMode-{post.id}" => fn () => $this->state = 'edit',
    "showMode-{post.id}" => fn () => $this->state = 'show',
]);

$editMode = fn() => $this->dispatch("editMode-" . $this->post->id);

$delete = function () {
    $this->post->delete();
    if ($this->post->file) {
        Storage::delete($this->post->file->url);
        $this->post->file->delete();
    }
    $this->redirect(route('posts.index'), navigate: true);
};

$verify = fn() => $this->post->update([
    'verified' => true
]); 

?>

<div @class([
    "bg-white overflow-hidden shadow-sm sm:rounded-lg",
    "opacity-50" => ! $post->verified,
    "mt-6" => !$loop->first
    ])>
    <div class="px-5 pt-4 pb-1 text-gray-900">
        <div class="flex justify-between opacity-100">
            <div class="flex gap-2">
                <x-profile-picture :src="asset($post->user->profile->url)" class="h-10 shadow" />
                <div>
                    <h1 class="font-bold">{{ $post->user->name }}</h1>
                    <div class="flex leading-3 text-xs">
                        <p class="">
                            <span>{{ $post->user->role->name }}</span>
                            <span>&#x2022</span>
                            {{-- <span>{{ $post->user->email }}</span> --}}
                            {{-- <span>&#x2022</span> --}}
                            <span>{{ $post->updated_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @if ($this->state === 'show' && (auth()->user()->role->id === 1 || auth()->user()->id === $post->user->id))
                <x-dropdown align="right" width="24">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <x-bootstrap-icons icon="three-dots" class="h-5" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @role('Admin')
                            @if (!$post->verified)
                                <x-dropdown-link wire:click.prevent='verify' wire:confirm="Are you sure you want to approve this post?">
                                    {{ __('Verify') }}
                                </x-dropdown-link>
                            @endif
                        @endrole

                        @if(auth()->user()->id === $post->user->id)
                            <x-dropdown-link wire:click.prevent='editMode'>
                                {{ __('Edit') }}
                            </x-dropdown-link>
                            <x-dropdown-link wire:click.prevent='delete' wire:confirm="Are you sure you want to delete this post?">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            @endif
            
        </div>
        @if ($this->state === 'show') 
            <div class="mt-4">
                <p class="{{ $post->file ? 'text-lg' : 'text-3xl' }}">{{ $post->content }}</p>
            </div>
        @elseif ($this->state === 'edit')
            @livewire('post.edit', ['post' => $this->post])
        @endif
    </div>
    @if($post->file)
        <img class="w-full" src="{{ asset($post->file->url) }}" alt="">
    @endif

    @livewire('comments.index', ['post' => $post])
</div>
