<?php

use function Livewire\Volt\{state};

state([
    'user',
    'message',
])

?>

<div class="">
    <div class="flex justify-end gap-2">
        <div>
            <div class="flex justify-end">
                <div title="{{ $message->created_at->diffForHumans() }}" @class([
                    'bg-red-500  text-white py-2 px-4',
                    'rounded-3xl' => !$message->file,
                    'rounded rounded-l-2xl rounded-tr-2xl' => $message->file
                ])>
                    {{ $message->content }}
                </div>
            </div>
            @if ($message->file)
                <img wire:click="$dispatch('open-modal', 'enlarge-picture-{{ $message->id }}')" class="mt-1 max-h-52 rounded rounded-l-2xl rounded-br-2xl" src="{{ asset($message->file->url) }}" alt="">
            @endif
        </div>
    </div>
</div>