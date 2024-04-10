<?php

use function Livewire\Volt\{state, layout, mount};

use App\Models\User;

layout('layouts.app');

state([
    'user',
    'users' => User::whereNot('id', auth()->user()->id)->get(),
]);

mount(function () {
    $this->user = User::where('id', $this->user)->first();
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
            <h2 class="font-extrabold text-2xl my-4 text-gray-800 leading-tight">
                {{ __('Chats') }}
            </h2>
            <div class="flex-1 pb-5 border-t overflow-scroll no-scrollbar">
                @foreach ($users as $userNavigation)
                    @if(!$userNavigation->verification?->verified && $userNavigation->role->id !== 1 )
                        @continue
                    @endif
                    <div class="my-2">
                        <a href="{{ route('messages.show', ['user' => $userNavigation->id]) }}">
                            <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
                                <div>
                                    <x-profile-picture class="h-14" :src="asset($userNavigation->profile->url)" />
                                </div>
                                <div class="my-auto">
                                    <h1 class="font-bold">
                                        {{ $userNavigation->name }}
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-3 flex flex-col h-full">
            <div class="flex gap-2 p-3 border-b shadow">
                <x-profile-picture class="h-10" :src="asset($user->profile->url)" />
                <div class="font-bold text-lg my-auto">
                    {{ $user->name }}
                </div>
            </div>
            <div class="flex-1">
                <livewire:messages.content :$user />
            </div>
            {{-- <livewire:messages.create :receiver="$user" @send="$refresh" /> --}}
            @livewire('messages.create', ['receiver' => $user])
        </div>
    </div>
</div>
