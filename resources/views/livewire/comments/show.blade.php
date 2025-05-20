<?php

use function Livewire\Volt\{state, computed};
use Carbon\CarbonInterface;

state([
    'comment',
    'create' => false,
    'liked' => fn() => $this->comment->likes->where('user_id', auth()->user()->id)->first() ? true : false,
    'edit' => false,
    "durationTime" => 0,
    'durationUnit' => "Minutes",
]);

$createComment = fn() => $this->create = !$this->create;

$like = function () {
    // check if auth likes the forum
    $like = $this->comment->likes->where('user_id', auth()->user()->id)->first();
    if(! $like) {
        // remove from db if liked
        $this->comment->likes()->create([
            'user_id' => auth()->user()->id
        ]);
    } else {
        $like->delete();
    }

    $this->redirect(request()->header("Referer"));
    // add to db if not liked
};

$likes = computed(function () {
    return $this->comment->likes->count();
});

$delete = function () {
    if ($this->comment->file) {
        Storage::delete($this->comment->file->url);
        $this->comment->file->delete();
    }
    $this->comment->delete();
    $this->redirect(request()->header('Referer'), navigate: true);
};

$toggleEdit = fn() => $this->edit = !$this->edit;

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
    

    $this->comment->user->update([
        'restricted_until' => $time
    ]);

    $this->comment->update([
        'restricted' => true,
    ]);
}

?>

<div class="w-full">
    <div class="w-full flex mt-4 gap-2">
        <div class="flex flex-col gap-1">
            <x-profile-picture class="h-8 shadow" :src="asset($comment->user->profile->url)" />
            @if($this->comment->comments->count() > 0)
                <div class="flex-1">
                    <div class="border-e-2 w-4 h-full">
                    </div>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <div class="px-3 py-1 rounded-2xl w-full">
                <div class="flex justify-between">
                    <h1 class="text-sm font-bold">{{ $comment->user->name }} <span class="text-neutral-500 font-medium">&#x2022 {{ $comment->user->role->name }}</span></h1>
                    @if(auth()->user()->id === $comment->user->id)
                        <x-dropdown align="right" width="24">
                            <x-slot name="trigger">
                                <button class=" inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <x-bi-three-dots class="h-5" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link class="cursor-pointer" wire:click.prevent='toggleEdit()'>
                                    {{ __($this->edit ? 'Cancel' : 'Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link class="cursor-pointer" wire:click.prevent='delete()' wire:confirm="Are you sure you want to delete this comment?">
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
                @if (!$this->comment->restricted)
                    @if(!$this->edit)
                        <p class="w-full wrap-anywhere">{{ $comment->content }}</p>
                    @else
                        <livewire:comments.edit :$comment />
                    @endif
                @else
                    <p class="italic font-bold text-sm text-gray-500 mt-2">
                        This comment has been restricted
                    </p>
                @endif
                
            </div>
            @if ($comment->file)
                <img wire:click="$dispatch('open-modal', 'enlarge-picture-comment-{{ $comment->id }}')" class="rounded-2xl mt-1 max-h-40 cursor-pointer" src="{{ asset($comment->file->url) }}" alt="">
                <x-modal name="enlarge-picture-comment-{{ $comment->id }}" :show="$errors->isNotEmpty()" focusable>
                    <img src="{{ asset($comment->file->url) }}" alt="">
                    <span class="text-sm font-bold cursor-pointer absolute top-2 right-2 hover:bg-white hover:bg-opacity-50 transition linear rounded-full" x-on:click="$dispatch('close')">
                        <x-bootstrap-icons icon="x" class="fill-white transition linear h-5 drop-shadow"/>
                    </span>
                </x-modal>
            @endif
            @if(!$this->comment->restricted)
                <div class="text-xs text-gray-500 mt-1 flex select-none font-bold">
                    <div x-on:click='$wire.like' @class([
                        "my-auto flex gap-1 cursor-pointer hover:bg-neutral-50 px-1 rounded",
                        "text-red-400" => $this->liked
                    ])>
                        <x-bi-heart class="h-3 w-3 my-auto" />
                        <div>{{ $this->likes }}</div>
                    </div>
                    <span class="">&#x2022</span>
                    <div x-on:click='$wire.createComment' class="my-auto flex gap-1 cursor-pointer hover:bg-neutral-50 px-1 rounded">
                        <x-bi-chat class="h-3 w-3 my-auto" />
                        <div>Reply</div>
                    </div>
                    @if ($this->comment->user->role->id !== 1)
                        @role('admin')
                            <span>&#x2022</span>
                            <div x-on:click="$dispatch('open-modal', 'restrict-comment-{{ $this->comment->id }}')" class="my-auto flex gap-1 cursor-pointer hover:bg-neutral-50 px-1 rounded">
                                <x-bi-exclamation-diamond class="h-3 w-3 my-auto" />
                                <div>Restrict</div>
                            </div>
                            <x-modal name="restrict-comment-{{ $comment->id }}" :key="'restrict-comment-' . $this->comment->id" focusable>
                                <div class="p-4 grid gap-4">
                                    <h1 class="text-lg font-bold">Restrict comment</h1>
                                    <div class="w-full flex border gap-4 p-4">
                                        <x-profile-picture class="h-8 shadow" :src="asset($comment->user->profile->url)" />
                                        <div class="">
                                            <div class="rounded-2xl">
                                                <div class="flex justify-between">
                                                    <h1 class="text-sm font-bold text-black">{{ $comment->user->name }} 
                                                        <span class="text-neutral-500 font-medium">&#x2022 {{ $comment->user->role->name }}</span>
                                                    </h1>
                                                </div>
                                                <p class="text-black font-normal">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <h1 class="font-bold">Restriction:</h1>
                                        <div class="flex gap-2">
                                            <x-text-input wire:model='durationTime' class="flex-1 text-sm" placeholder="Duration" type="number" />
                                            <div class="text-sm">
                                                <select wire:model='durationUnit' class="border-gray-300 rounded-md w-full text-sm">
                                                    <option value="Minutes">Minutes</option>
                                                    <option value="Hours">Hours</option>
                                                    <option value="Days">Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex-1 my-auto"><span class="font-bold text-red-500">Note:</span> Restricting the comment will also indefinitely restrict/hide the user.</div>
                                        <x-primary-button wire:click="restrict" class="">Restrict</x-primary-button>
                                    </div>
                                </div>
                            </x-modal>
                        @endrole
                    @endif
                    <span class="px-1=">&#x2022</span>
                    <span class="px-1">{{ $comment->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                </div>
            @endif
        </div>
    </div>
    @if($this->create)
        <div class="flex gap-1">
            <div class="flex">
                <div class=" w-8 h-full">
                    @if($this->comment->comments->count() > 0)
                        <div class="w-4 h-full border-e-2">
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex-1">
                <livewire:comments.create :commentable="$this->comment" :key="'comment-create-'. $comment->id" >

                {{-- @livewire("comments.create", ["commentable" => $this->comment], "comment-create-" . $this->comment->id) --}}
            </div>
        </div>
    @endif
    <div class="">
        @foreach ($this->comment->comments as $commentChild)
            <div wire:key="{{ "comment-loop-$commentChild->id" }}" class="flex gap-1">
                <div class="flex">
                    <div @class([
                        "border-e-2 w-4 h-full" => !$loop->last,
                        "border-e-0 w-[calc(1rem-2px)]" => $loop->last
                    ])>
                    </div>
                    
                    <div @class([
                        "border-b-2 h-8 w-5 rounded-bl-xl",
                        "border-s-2" => $loop->last
                    ])>
                    </div>
                </div>
                <div class="flex-1">
                    <livewire:comments.show :comment="$commentChild" :key="'comment-'. $commentChild->id" >
                    {{-- <livewire:comments.show :comment="$commentChild" > --}}
                    {{-- @livewire("comments.show", ["comment" => $commentChild], "comment-child-$commentChild->id") --}}
                </div>
            </div>
        @endforeach
    </div>
</div>
