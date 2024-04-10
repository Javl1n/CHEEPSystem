<?php

use function Livewire\Volt\{state, boot};

use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;

state([
    'user',
    'messages'
]);

boot(function () {
    $this->messages = Message::
                        where(function (Builder $query) {
                            $query
                                ->where('sender_id', $this->user->id)
                                ->where('receiver_id', auth()->user()->id);
                        })
                        ->orWhere(function (Builder $query) {
                            $query
                                ->where('sender_id', auth()->user()->id)
                                ->where('receiver_id', $this->user->id);
                        })->latest()->get();
});

?>

<div class="flex flex-col-reverse gap-5 w-full py-4 px-4 h-[calc(100vh-64px-64px-56px)] overflow-auto" wire:poll.1000ms>
    @foreach ($messages as $message)
        @if ($message->sender_id === $user->id)
            <div class="flex gap-2">
                <x-profile-picture class="h-10 shadow" :src="asset($user->profile->url)" />
                <div>
                    <div class="flex">
                        <div title="{{ $message->created_at->diffForHumans() }}" @class([
                            'rounded-3xl' => !$message->file,
                            'bg-gray-100 py-2 px-4',
                            'rounded rounded-r-2xl rounded-tl-2xl' => $message->file
                        ])>
                            {{ $message->content }}
                        </div>
                    </div>
                    @if ($message->file)
                        <img class="mt-1 max-h-52 rounded rounded-r-2xl rounded-bl-2xl" src="{{ asset($message->file->url) }}" alt="">
                    @endif
                </div>
            </div>
        @else
            <div class="flex justify-end gap-2">
                <div>
                    <div class="flex justify-end">
                        <div title="{{ $message->created_at->diffForHumans() }}" @class([
                            'rounded-3xl' => !$message->file,
                            'bg-gray-100 py-2 px-4',
                            'rounded rounded-l-2xl rounded-tr-2xl' => $message->file
                        ])>
                            {{ $message->content }}
                        </div>
                    </div>
                    @if ($message->file)
                        <img class="mt-1 max-h-52 rounded rounded-l-2xl rounded-br-2xl" src="{{ asset($message->file->url) }}" alt="">
                    @endif
                </div>
            </div>
        @endif
    @endforeach
    
</div>
