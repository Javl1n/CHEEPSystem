<?php

use function Livewire\Volt\{state, computed};

use App\Models\User;
use App\Models\Message;

use Illuminate\Database\Eloquent\Builder;

state([
    'users',
    'search' => ''
]);

$searchUser = function () {
    if($this->search === "") {
        $this->users = User::whereNot('id', auth()->user()->id)
            ->whereHas('verification', function (Builder $query) {
                $query->where('verified', true);
            })->get();
    } else {
        $this->users = User::whereNot('id', auth()->user()->id)
        ->whereHas('verification', function (Builder $query) {
            $query->where('verified', true);
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
};

$hasNewAnnouncements = computed(function () {
    $announcements = Message::
        where('receiver_id', auth()->user()->id)
        ->where('sender_id', $this->users->where('role_id', 1)->first()->id)
        ->where('read', false)->first();

    return $announcements ? true : false;
})

?>

<div>
    <div class="flex justify-between my-4 leading-tight">
        <h2 class="font-extrabold text-2xl text-gray-800">
            {{ __('Chats') }}
        </h2>
        <div class="my-auto">
            <x-text-input wire:model="search" wire:keyup="searchUser" placeholder="Search users..." class="block w-40 py-1 text-sm" type="text" name="name"/>
        </div>
    </div>
    <div class="h-[calc(100vh-64px-52px)] flex-1 pb-5 border-t overflow-scroll no-scrollbar">
        @role('admin')
            <div class="my-2">
                <a href="{{ route("admin.messages.announcements") }}">
                {{-- <a href="{{ route('messages.show', ['user' => $user->id]) }}"> --}}
                    <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
                        <div class="rounded-full border-4 border-transparent">
                            {{-- <x-profile-picture class="h-14" :src="asset($user->profile->url)" /> --}}
                                <x-bi-exclamation-circle-fill class="h-14 w-14 text-neutral-400" />
                        </div>
                        <div class="my-auto">
                            <h1 class="font-bold">
                                Announcements
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        @else
            <div wire:poll class="my-2">
                <a href="{{ route("messages.announcements") }}">
                {{-- <a href="{{ route('messages.show', ['user' => $user->id]) }}"> --}}
                    <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
                        <div @class([
                            "rounded-full border-4",
                            "border-red-500" => $this->hasNewAnnouncements(),
                            "border-transparent" => !$this->hasNewAnnouncements(),
                        ])>
                            {{-- <x-profile-picture class="h-14" :src="asset($user->profile->url)" /> --}}
                                <x-bi-exclamation-circle-fill class="h-14 w-14 text-neutral-400" />
                        </div>
                        <div class="my-auto">
                            <h1 class="font-bold">
                                Announcements
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        @endrole
        @foreach ($users as $user)
            @if((!$user->verification?->verified) || $user->role->id === 1)
                @continue
            @endif
            <livewire:messages.nav-item :$user />
        @endforeach
    </div>
</div>