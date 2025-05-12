<?php

use function Livewire\Volt\{state, computed};
use Illuminate\Support\Carbon;

state([
    'user',
    'durationTime' => 0,
    'durationUnit' => "Minutes",
]);

$verifyUser = function () {
    $this->user->verification->update([
        'verified' => true
    ]);
};

$deleteUser = function () {
    $this->user->verification->update([
        'verified' => false
    ]);
};

$date = computed(function () {
    return Carbon::parse($this->user->restricted_until)->diffForHumans(now());
});

$restrictUser = function () {
    if ($this->durationTime < 1) {
        return;
    }
    
    
    switch($this->durationUnit) {
        case "Minutes":
            $time = now()->addMinutes((int)$this->durationTime);
            break;
        case "Hours":
            $time = now()->addHours((int)$this->durationTime);
            break;
        case "Days":
            $time = now()->addDays((int)$this->durationTime);
            break;
    }    
    

    $this->user->update([
        'restricted_until' => $time
    ]);
    
};

?>

<div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex gap-2">
            <x-profile-picture class="h-12 shadow" src="{{ asset($user->profile->url) }}" />
            <div class="flex-1">
                <div class="flex justify-between gap-2">
                    <h1 class="text-lg">{{ $user->name }}</h1>
                </div>
                <p class="text-sm leading-3"> {{ $user->role->name }} <span>&#x2022</span> {{ $user->email }}</p>
            </div>
        </div>
        <div class="mt-4">
            <h1 class="font-bold">Status: 
                <span @class([
                    "font-normal",
                    "text-green-500" => $user->verification->verified,
                    "text-gray-500" => ! $user->verification->verified
                ])>
                    @if($user->verification->verified === null) 
                        <span class="text-red-500">Unverified</span>
                    @else
                        @if ($user->verification->verified)
                            <span class="text-green-500">Verified</span>
                        @else
                            <span class="text-gray-500">Deleted</span>
                        @endif
                        {{-- {{ $user->verification->verified ? 'Verified' : 'Deleted' }} --}}
                    @endif
                    {{-- {{ $user->verification->verified == null ? 'Unverified' : ($user->verification->verified ? 'Verified' : 'Deleted') }} --}}
                </span>
                @if ($user->verification->verified)
                    -
                    <span class="font-normal {{ $user->restricted_until ? 'text-red-500' : 'text-green-500' }}">
                        {{ $user->restricted_until ? $this->date : 'Unrestricted' }}
                    </span>
                @endif
            </h1>
           
            {{-- verification --}}
            <div x-data="{open: true}" class="border border-gray-400 px-4 py-2 mt-2 rounded">
                <div class="flex justify-between">
                    <h1 class="font-bold">Verification:</h1>
                    <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open">
                        <x-bi-x class="transition linear h-5 w-5" x-bind:class="open ? '' : 'rotate-45'" />
                    </span>
                </div>
                <div  x-show="open" x-collapse>
                    <div class="w-full border rounded flex justify-center">
                        <img class="" src="{{ asset($user->verification->file->url) }}" alt="">
                    </div>
                    @if($user->verification->verified === null)
                        <div class="flex justify-between mt-4">
                            <div class="my-auto font-bold text-xs">
                                Warning: <span class="text-red-500">Rejecting a verification will result in the account being deleted when the user logs in for the first time.</span>
                            </div>
                            <div class="flex gap-4 my-auto">
                                <x-primary-button wire:click='deleteUser' class="bg-red-600 hover:bg-red-500">Reject</x-primary-button>
                                <x-primary-button wire:click='verifyUser'>Verify</x-primary-button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($user->verification->verified)
                {{-- Restriction --}}
                <div x-data="{open: false}" class="border border-gray-400 px-4 py-2 mt-2 rounded">
                    <div class="flex justify-between">
                        <h1 class="font-bold">Restriction:</h1>
                        <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open">
                            <x-bi-x class="transition linear h-5 w-5" x-bind:class="open ? '' : 'rotate-45'" />
                        </span>
                    </div>
                    <div  x-show="open" x-collapse>
                        <div class="flex gap-2 mt-2"> 
                            <x-text-input wire:model='durationTime' class="flex-1" placeholder="Duration" type="number" />
                            <div class="">
                                <select wire:model='durationUnit' class="border-gray-300 rounded-md w-full">
                                    <option value="Minutes">Minutes</option>
                                    <option value="Hours">Hours</option>
                                    <option value="Days">Days</option>
                                </select>
                            </div>
                            {{-- <button wire:click='restrictUser' @class([
                                "uppercase text-white px-4 py-2 rounded-md shadow text-sm font-bold transition",
                                // 'hover:bg-red-700' => ! $user->restricted,
                            ])>
                                {{ $user->restricted ? 'Unrestrict' : 'Restrict' }}
                            </button> --}}
                            <x-primary-button wire:click='restrictUser'>Restrict</x-primary-button>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
