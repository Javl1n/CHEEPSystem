<?php

use function Livewire\Volt\{state};

state([
    'report',
    'receiver' => fn() => $this->report->message->receiver,
    'sender' => fn() => $this->report->message->sender,
    'message' => fn() => $this->report->message,
    "durationTime" => 0,
    'durationUnit' => "Minutes",
]);

$restrict = function () {
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
    

    $this->sender->update([
        'restricted_until' => $time
    ]);

    $this->report->update([
        'restricted' => true,
    ]);
}

?>

<div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex gap-2">
            <x-profile-picture class="h-12 shadow" src="{{ asset($receiver->profile->url) }}" />
            <div class="flex-1">
                <div class="flex justify-between gap-2">
                    <h1 class="text-lg">{{ $receiver->name }}</h1>
                </div>
                <p class="text-sm leading-3"> {{ $receiver->role->name }} <span>&#x2022</span> {{ $receiver->email }} <span>&#x2022</span> {{ $report->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="mt-4">
            <h1 class="font-bold">Report: 
                <span @class([
                    "font-normal",
                ])>
                    {{ $this->report->description }}
                </span>
            </h1>
            
            
            <div class="rounded border">
                <div class="flex gap-2 p-2">
                    <x-profile-picture class="h-10 shadow" src="{{ asset($sender->profile->url) }}" />
                    <div class="flex-1">
                        <div class="flex justify-between gap-2">
                            <h1 class="">{{ $sender->name }}</h1>
                        </div>
                        <p class="text-xs leading-3"> {{ $sender->role->name }} <span>&#x2022</span> {{ $sender->email }} <span>&#x2022</span> {{ $message->created_at->diffForHumans() }} </p>
                    </div>
                </div>
                <div class="bg-gray-100">
                    <div class="flex gap-2 py-10 px-20  scale-105">
                        <x-profile-picture class="h-10 shadow" :src="asset($sender->profile->url)" />
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
            </div>
                
            <div class="mt-2">
                <h1 class="font-bold">Restriction:</h1>
                <div class="flex gap-2">
                    <x-text-input wire:model='durationTime' class="flex-1" placeholder="Duration" type="number" />
                    <div class="">
                        <select wire:model='durationUnit' class="border-gray-300 rounded-md w-full">
                            <option value="Minutes">Minutes</option>
                            <option value="Hours">Hours</option>
                            <option value="Days">Days</option>
                        </select>
                    </div>
                    <x-primary-button wire:click='restrict'>Restrict</x-primary-button>
                </div>
            </div>
            <div class="text-sm mt-2 text-gray-600">
                <span class="font-bold text-red-500">Note:</span> Restricting the user will also indefinitely restrict/hide the reported message.
            </div>
        </div>
    </div>
</div>
