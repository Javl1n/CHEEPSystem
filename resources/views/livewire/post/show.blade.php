<?php

use function Livewire\Volt\{state};
use Carbon\CarbonInterface;

state([
    'post'
]);

?>

<div class="bg-white mt-6 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="px-6 pt-4 pb-2 text-gray-900">
        <div class="flex gap-2">
            <x-profile-picture :src="asset($post->user->profile->url)" class="h-10 shadow" />
            <div>
                <h1>{{ $post->user->name }}</h1>
                <div class="flex leading-3 text-xs">
                    <p class="">
                        <span>{{ $post->user->role->name }}</span>
                        <span>&#x2022</span>
                        {{-- <span>{{ $post->user->email }}</span> --}}
                        {{-- <span>&#x2022</span> --}}
                        <span>{{ $post->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-lg">{{ $post->content }}</p>
        </div>
        
    </div>
    @if($post->file)
        <img class="w-full" src="{{ asset($post->file->url) }}" alt="">
    @endif
    @livewire('comments.index', ['post' => $post])
</div>
