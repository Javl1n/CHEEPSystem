<?php

use App\Models\Post;
use Carbon\CarbonInterface;
use function Livewire\Volt\{state, layout, mount, computed};


layout('layouts.app');

state([
    'post',
]);

mount(function () {
    $this->post = Post::find($this->post);
});

?>

<div class="overflow-auto pb-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forums') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div @class([
            "bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 mx-auto",
            "opacity-50" => ! $post->verified,
        ])>
            <div class="px-5 py-4 text-gray-900">
                <div class="flex justify-between opacity-100">
                    <div class="flex gap-2">
                        <x-profile-picture :src="asset($post->user->profile->url)" class="h-10 shadow" />
                        <div>
                            <h1 class="font-bold">k/{{ $post->category->name }}</h1>
                            <div class="flex leading-3 text-xs">
                                <p class="">
                                    <span>{{ $post->user->name }}</span>
                                    <span>&#x2022</span>
                                    <span>{{ $post->user->role->name }}</span>
                                    <span>&#x2022</span>
                                    {{-- <span>{{ $post->user->email }}</span> --}}
                                    {{-- <span>&#x2022</span> --}}
                                    <span>{{ $post->updated_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="mt-4">
                        <p class="{{ $post->file ? 'text-lg' : 'text-3xl' }}">{{ $post->content }}</p>
                    </div>
                    @if($post->file)
                        <div class="border rounded mt-4">
                            <img class="mx-auto" src="{{ asset($post->file->url) }}" alt="">
                        </div>
                    @endif
            </div>
            
            @livewire('post.index-footer', ['post' => $post])
            @livewire('comments.index', ['post' => $post])
        </div>
    </div>
</div>
