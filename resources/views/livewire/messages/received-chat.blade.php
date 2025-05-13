<?php

use function Livewire\Volt\{state};

state([
    'user',
    'message'
])

?>

<div class="">
    <div class="flex gap-2">
        @if($user->role->id === 1)
            <x-bi-exclamation-circle-fill class="h-10 w-10 text-neutral-400" />
        @else
            <x-profile-picture class="h-10 shadow" :src="asset($user->profile->url)" />
        @endif
        <div>
            <div class="flex">
                <div title="{{ $message->created_at->diffForHumans() }}" @class([
                    'rounded-3xl' => !$message->file,
                    'bg-white py-2 px-4 shadow-sm',
                    'rounded rounded-r-2xl rounded-tl-2xl' => $message->file
                ])>
                    {{ $message->content }}
                </div>
                <div>
    
                </div>
            </div>
            @if ($message->file)
                <img wire:click="$dispatch('open-modal', 'enlarge-picture-{{ $message->id }}')" class="mt-1 max-h-52 rounded rounded-r-2xl rounded-bl-2xl" src="{{ asset($message->file->url) }}" alt="">
            @endif
        </div>
    </div>
</div>
