<?php

use function Livewire\Volt\{state, layout};

use App\Models\Post;

layout('layouts.app');

state([
    'posts' => Post::latest()->get(),
]);

?>

<div class="">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-8 py-12 px-6 lg:px-8">
        <div class="col-span-2">
            @livewire('post.create')
            @foreach ($posts as $post)
                @livewire('post.show', ['post' => $post])
            @endforeach
        </div>
        <div class="col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Profile") }}
                </div>
            </div>
        </div>
    </div>
</div>
