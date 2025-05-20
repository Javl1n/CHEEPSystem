<?php

use function Livewire\Volt\{state, layout};

use App\Models\Post;

layout('layouts.app');

state([
    'posts' => fn() => Post::latest('updated_at')->get(),
    "category" => 0
]);

$selectCategory = function ($category) {
    $this->category = $category;

    if ((int) $category === 0){
        $this->posts = Post::latest('updated_at')->get();
    } else {
        $this->posts = Post::where('category_id', (int) $category)->latest('updated_at')->get();
    }
}

?>

<div class="overflow-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forums') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-12 px-6 lg:px-8">
        
        <div class="mt-4">
            @unlessrole('Admin')
                <livewire:post.create>
                {{-- @livewire('post.create') --}}
            @endrole

            <div  class="flex gap-2">
                <div wire:click='selectCategory(0)' @class([
                    "rounded-lg bg-white py-2 px-4 border select-none cursor-pointer",
                    "ring-1 text-blue-600" => (int) $this->category === 0
                ])>All</div>
                @foreach (\App\Models\Category::all() as $category)
                    <div wire:click='selectCategory({{ $category->id }})' @class([
                        "rounded-lg bg-white py-2 px-4 border select-none cursor-pointer",
                        "ring-1 text-blue-600" => (int) $this->category === $category->id
                    ])>{{ $category->name }}</div>
                @endforeach
            </div>

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
                <livewire:post.show :$post :$loop :key="'post-' . $post->id" />
                @if ($loop->last)
                    <div class="my-6 border-b font-bold text-gray-500 text-center">
                        Verified Posts
                    </div>
                @endif
            @endforeach
            <div class="mt-6">
                @foreach ($this->posts->where("verified", true) as $post)
                    <livewire:post.show :$post :$loop :key="'post-' . $post->id" />
                @endforeach
            </div>
        </div>
    </div>
</div>
