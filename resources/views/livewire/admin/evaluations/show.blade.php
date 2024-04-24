<?php

use function Livewire\Volt\{state};



?>

<div>
    <div @class([
        "bg-white overflow-hidden shadow-sm sm:rounded-lg",
        "mt-6" => 0
    ])>
        <div class="p-6 text-gray-900">
            {{-- <div class="flex gap-2">
                <div>
                    <h1 class="font-bold">{{ $post->user->name }}</h1>
                    <div class="flex leading-3 text-xs">
                        <p class="">
                            <span>{{ $post->user->role->name }}</span>
                            <span>&#x2022</span>
                            <span>{{ $post->user->email }}</span>
                            <span>&#x2022</span>
                            <span>{{ $post->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true) }}</span>
                        </p>
                    </div>
                </div>
            </div> --}}
            <div class="my-4">
                <p class="text-xl">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Explicabo minima molestias dolores dicta obcaecati porro enim, cupiditate voluptates voluptatum qui facilis at omnis magni harum? Doloremque iure minus suscipit laboriosam?</p>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button wire:click.prevent='verifyUser'  class=" uppercase bg-red-600 text-white px-4 py-2 rounded-md shadow text-sm font-bold hover:bg-red-700 transition">
                    Delete
                </button>
                <button wire:click.prevent='verifyUser' class=" uppercase bg-black text-white px-4 py-2 rounded-md shadow text-sm font-bold hover:bg-gray-700 disabled:bg-gray-700 transition">
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>
