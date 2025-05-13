<?php

use function Livewire\Volt\{state, computed};
use App\Models\Message;

state([
    'user'
]);

$hasNewMessages = computed(function () {
    $messages = Message::
        where('receiver_id', auth()->user()->id)
        ->where('sender_id', $this->user->id)
        ->where('read', false)->first();

    return $messages ? true : false;
})

?>

<div class="my-2">
    <a href="{{ route('messages.show', ['user' => $user->id]) }}">
        <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
            <div wire:poll @class([
                "border-4 rounded-full",
                "border-red-500" => $this->hasNewMessages,
                "border-transparent" => !$this->hasNewMessages,
            ])>
                <x-profile-picture class="h-14" :src="asset($user->profile->url)" />
            </div>
            <div class="my-auto">
                <h1 class="font-bold">
                    {{ $user->name }}
                </h1>
            </div>
        </div>
    </a>
</div>
