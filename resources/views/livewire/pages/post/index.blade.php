<?php

use function Livewire\Volt\{state, layout};

use App\Models\Post;

layout('layouts.app');

state([
    'posts' => Post::latest()->get(),
]);

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="grid lg:grid-cols-6 gap-8 py-12 px-6 lg:px-8">
        <div class="col-start-2 col-span-4">
            @unlessrole('Student')
                @livewire('post.create')
            @endrole
            
            @foreach ($posts as $post)
                @livewire('post.show', ['post' => $post, 'loop' => $loop])
            @endforeach
        </div>
        {{-- <div class="col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Profile") }}
                </div>
            </div>
        </div> --}}
    </div>
</div>
