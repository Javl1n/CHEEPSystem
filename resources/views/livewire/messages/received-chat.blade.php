<?php

use function Livewire\Volt\{state};

state([
    'user',
    'message',
    'reason'
]);

$toggleLike = function() {
    $this->message->update([
        "liked" => !$this->message->liked
    ]);
};

$report = function () {
    $this->message->report()->create([
        "description" => $this->reason
    ]);

    $this->redirect(request()->header("Referer"));
}

?>

<div class="">
    <div class="flex gap-2">
        @if($user->role->id === 1)
            <x-bi-exclamation-circle-fill class="h-10 w-10 text-neutral-400" />
        @else
            <x-profile-picture class="h-10 shadow" :src="asset($user->profile->url)" />
        @endif
        @if (!$this->message->report?->restricted)
            <div>
                <div class="flex gap-2">
                    <div title="{{ $message->created_at->diffForHumans() }}" @class([
                        'rounded-3xl' => !$message->file,
                        'bg-white py-2 px-4 shadow-sm',
                        'rounded rounded-r-2xl rounded-tl-2xl' => $message->file
                    ])>
                        {{ $message->content }}
                    </div>
                    <div wire:click='toggleLike()' class="my-auto cursor-pointer">
                        @if($message->liked)
                            <x-bi-heart-fill class="text-red-500" />
                        @else
                            <x-bi-heart class="text-gray-400" />
                        @endif
                    </div>
                    @if($message->report)
                        <x-bi-flag-fill class="text-gray-300 my-auto" />
                    @else
                        <div wire:click="$dispatch('open-modal', 'report-message-{{ $message->id }}')" class="my-auto cursor-pointer">
                            <x-bi-flag class="text-gray-400" />
                        </div>
                    @endif
                </div>
                @if ($message->file)
                    <img wire:click="$dispatch('open-modal', 'enlarge-picture-{{ $message->id }}')" class="mt-1 max-h-52 rounded rounded-r-2xl rounded-bl-2xl" src="{{ asset($message->file->url) }}" alt="">
                @endif
            </div>
            <x-modal name="report-message-{{ $message->id }}" :key="'enlarge-picture-' . $this->message->id" focusable>
            <div class="p-4 grid gap-4">
                <h1 class="text-lg font-bold">Report a message</h1>
        
                <div class="rounded border w-full py-10 px-20 bg-gray-100">
                    <div class="flex gap-2 scale-105">
                        <x-profile-picture class="h-10 shadow" :src="asset($user->profile->url)" />
                        <div>
                            <div class="flex gap-2">
                                <div title="{{ $message->created_at->diffForHumans() }}" @class([
                                    'rounded-3xl' => !$message->file,
                                    'bg-white py-2 px-4 shadow-sm',
                                    'rounded rounded-r-2xl rounded-tl-2xl' => $message->file
                                ])>
                                    {{ $message->content }}
                                </div>
                            </div>
                            @if ($message->file)
                                <img wire:click="$dispatch('open-modal', 'enlarge-picture-{{ $message->id }}')" class="mt-1 max-h-52 rounded rounded-r-2xl rounded-bl-2xl" src="{{ asset($message->file->url) }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label>Reason for the report</x-input-label>
                    <x-text-input wire:model='reason' class="w-full" placeholder="Anything..." />
                </div>
                <div class="flex justify-end">
                    <x-primary-button wire:click="report()" class="">Submit</x-primary-button>
                </div>
            </div>
        </x-modal>
        @else
            <div>
                <div title="{{ $message->created_at->diffForHumans() }}" @class([
                        'border-2 py-2 px-4 text-sm rounded-full font-bold text-gray-500 italic',
                    ])>
                        This message has been hidden
                    </div>
            </div>
        @endif
    </div>
        

    
    
</div>
