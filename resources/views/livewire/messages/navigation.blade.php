<?php

use function Livewire\Volt\{state, boot};

use App\Models\User;

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
    <div class="flex-1 pb-5 border-t overflow-scroll no-scrollbar">
        @foreach ($users as $user)
            @if(!$user->verification?->verified && $user->role->id !== 1)
                @continue
            @endif
            <div class="my-2">
                <a href="{{ route('messages.show', ['user' => $user->id]) }}">
                    <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
                        <div>
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
        @endforeach
    </div>
</div>