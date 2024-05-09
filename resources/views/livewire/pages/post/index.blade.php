<?php

use function Livewire\Volt\{state, layout};

use App\Models\Post;

layout('layouts.app');

state([
    'posts' => Post::latest('updated_at')->get(),
]);

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
        @unlessrole('Student')
            @livewire('post.create')
        @endrole
        
        @foreach ($posts->filter(function ($value, $key) {
            if($value->verified) {
                return false;
            }

            if(auth()->user()->role->id === 1) {
                return true;
            }

            if($value->user->id !== auth()->user()->id) {
                return false;
            }

            return true;
        }) as $post)
            @if ($loop->first)
                <div class="mb-6 border-b font-bold text-gray-500 text-center">
                    Unverified Posts
                </div>
            @endif
            @livewire('post.show', ['post' => $post, 'loop' => $loop])

            @if ($loop->last)
                <div class="my-6 border-b font-bold text-gray-500 text-center">
                    Verified Posts
                </div>
            @endif
        @endforeach

        <div class="mt-6">
            @foreach ($posts->where('verified', true) as $post)
                @livewire('post.show', ['post' => $post, 'loop' => $loop])
            @endforeach
        </div>
    </div>
</div>
