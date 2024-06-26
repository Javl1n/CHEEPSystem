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

<div class="bg-gray-50 flex flex-col-reverse gap-3 w-full py-4 px-4 h-[calc(100vh-64px-64px-70px)] overflow-auto" wire:poll.1000ms>
    @foreach ($messages as $message)
        <div class="">
            @if ($message->sender_id === $user->id)
                <div class="flex gap-2">
                    <x-profile-picture class="h-10 shadow" :src="asset($user->profile->url)" />
                    <div>
                        <div class="flex">
                            <div title="{{ $message->created_at->diffForHumans() }}" @class([
                                'rounded-3xl' => !$message->file,
                                'bg-white py-2 px-4',
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
            @else
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
            @endif
            @if ($message->file)
                <x-modal name="enlarge-picture-{{ $message->id }}" :show="$errors->isNotEmpty()" focusable>
                    <img src="{{ asset($message->file->url) }}" alt="">
                    <span class="text-sm font-bold cursor-pointer absolute top-2 right-2 hover:bg-white hover:bg-opacity-50 transition linear rounded-full" x-on:click="$dispatch('close')">
                        <x-bootstrap-icons icon="x" class="fill-white transition linear h-5 drop-shadow"/>
                    </span>
                </x-modal>
            @endif
        </div>
    @endforeach
    
</div>
