<?php

use function Livewire\Volt\{state};

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Storage;


state([
    'post'
]);

$delete = function ($commentID) {
    $comment = $this->post->comments->where('id', $commentID)->first();
    if ($comment->file) {
        Storage::delete($comment->file->url);
        $comment->file->delete();
    }
    $comment->delete();
    $this->redirect(request()->header('Referer'), navigate: true);
}

?>

<div class="px-5 py-4 text-gray-900">
    <div class="border-t-2">
    @livewire('comments.create', ['post' => $post])

        @foreach ($post->comments as $comment)
            <div wire:key='comment-{{ $comment->id }}' class="flex mt-4 gap-2">
                <x-profile-picture class="h-8 shadow" :src="asset($comment->user->profile->url)" />
                <div>
                    <div class="flex">
                        <div class=" bg-gray-100 px-3 py-1 rounded-2xl">
                            <h1 class="text-sm font-bold">{{ $comment->user->name }}</h1>
                            <p>{{ $comment->content }}</p>
                        </div>
                        @if(auth()->user()->id === $comment->user->id)
                            <div class="my-3 ms-2">
                                <x-dropdown align="right" width="24">
                                    <x-slot name="trigger">
                                        <button class=" inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <x-bootstrap-icons icon="three-dots" class="h-5" />
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link wire:click.prevent='delete({{ $comment->id }})' wire:confirm="Are you sure you want to delete this comment?">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
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
                    <div class="text-xs text-gray-500 mt-1 flex gap-1">
                        <div class="my-auto flex gap-1">
                            <x-bi-heart class="h-3 w-3 my-auto" />
                            <div>0</div>
                        </div>
                        <span>{{ $comment->user->role->name }}</span>
                        <span>&#x2022</span>
                        <span class="">{{ $comment->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                    </div>
                </div>
                
            </div>
        @endforeach
    </div>
</div>