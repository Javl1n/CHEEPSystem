<?php

use function Livewire\Volt\{state, layout, mount};

use App\Models\User;
use App\Models\Message;

layout('layouts.app');

state([
    'user',
    'users' => User::whereNot('id', auth()->user()->id)->get(),
]);

mount(function () {
    $this->user = User::where('role_id', 1)->first();

    Message::where('receiver_id', auth()->user()->id)
        ->where('sender_id', $this->user->id)
        ->update([
            'read' => true,
        ]);
});

?>

<div class="flex-1 bg-white flex flex-col">
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot> --}}
    <div class="flex-1 border-t grid grid-cols-4">
        <div class="col-span-1 border-r px-4 flex flex-col h-[calc(100vh-65px)] ">
            @livewire('messages.navigation', ['users' => $users])
        </div>
        <div class="col-span-3 flex flex-col h-full">
            <div class="flex gap-2 p-3 border-b shadow">
                <x-bi-exclamation-circle-fill class="h-10 w-10 text-neutral-400" />    
                <div class="font-bold text-lg my-auto">
                    Announcements
                </div>
            </div>
            <div class="flex-1">
                <livewire:messages.content :$user />
            </div>
            @livewire('messages.create', ['receiver' => $user])
        </div>
    </div>
</div>
