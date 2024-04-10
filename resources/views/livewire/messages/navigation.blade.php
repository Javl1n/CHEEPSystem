<?php

use function Livewire\Volt\{state, boot};

state([
    'users',
]);

?>

<div class="flex-1 pb-5 border-t overflow-scroll no-scrollbar">
    @foreach ($users as $user)
        @if(!$user->verification?->verified && $user->role->id !== 1 )
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