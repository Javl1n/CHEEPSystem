<?php

use function Livewire\Volt\{state};

use Illuminate\Support\Facades\Storage;


state([
    'post',
    'create' => false
]);

$toggleCreate = fn() => $this->create = !$this->create;

?>

<div class="px-5 pb-4 text-gray-900">
    <div class="border-t-2">
        <livewire:comments.create :commentable="$this->post" :key="'post-comment-create-'. $post->id" >
            
        {{-- @livewire('comments.create', ['commentable' => $post], "post-comment-create-$post->id") --}}
        @foreach ($post->comments()->orderBy('updated_at', 'desc')->get() as $comment)
            @livewire('comments.show', ["comment" => $comment],"comment-$loop->index")
        @endforeach
    </div>
</div>