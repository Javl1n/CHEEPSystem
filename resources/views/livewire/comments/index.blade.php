<?php

use function Livewire\Volt\{state};
use Carbon\CarbonInterface;


state([
    'post'
])

?>

<div class="px-6 py-2 text-gray-900">
    <div class="border-t-2">
        @foreach ($post->comments as $comment)
            <div class="flex mt-4 gap-2">
                <x-profile-picture class="h-8 shadow" :src="asset($comment->user->profile->url)" />
                <div>
                    <div class="flex">
                        <div class=" bg-gray-100 px-3 py-1 rounded-2xl">
                            <h1 class="text-sm font-bold">{{ $comment->user->name }}</h1>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                    @if ($comment->file)
                        <img class="rounded-2xl mt-1 max-h-40" src="{{ asset($comment->file->url) }}" alt="">
                    @endif
                    <div>
                        <span class="text-xs ms-2 text-gray-500">{{ $comment->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
    @livewire('comments.create', ['post' => $post])
</div>