<?php

use function Livewire\Volt\{rules, state, usesFileUploads};

usesFileUploads();

state([
    'post',
    'content',
    'image'
]);

$clearImage = function () {
    return $this->image = '';
};

$uploadComment = function () {
    $this->validate([
        'content' => 'required'
    ]);

    $comment = $this->post->comments()->create([
        'content' => $this->content,
        'user_id' => auth()->user()->id
    ]);

    if ($this->image) {
        $this->validate([
            'image' => 'image'
        ]);

        $comment->file()->create([
            'url' => $this->image->store('images/comments')
        ]);
    }

    return redirect('posts');
};

?>


<div class="flex mt-4 gap-2">
    <x-profile-picture class="h-8 shadow" :src="asset(auth()->user()->profile->url)"/>
    <div class="w-full">
        <textarea
            class="resize-none h-8 rounded-2xl bg-gray-100 w-full px-3 pt-1 pb-2 text-sm border-transparent focus:border-transparent overflow-hidden focus:ring-0"
            x-data="{
                resize: () => { $el.style.height = '1px'; $el.style.height = $el.scrollHeight + 'px' }
            }"
            x-init="resize()"
            x-on:input="resize()"
            wire:model='content'
            placeholder="Write a comment..."
            x-transition
            required
        ></textarea>
        <x-input-error :messages="$errors->get('content')" class="" />
        @if ($this->image)
            <div class="flex gap-2 mt-2">
                <img src="{{ $this->image->temporaryUrl() }}" class="max-h-40">
                <div>
                    <x-bootstrap-icons x-on:click="$wire.clearImage" icon="x" class="h-6 bg-gray-200 cursor-pointer hover:bg-gray-300 rounded-full transition" />
                </div>
            </div>
        @endif
    </div>
    <input type="file" class="hidden" id="image" wire:model='image'>
    @if (!$this->image)
        <label for="image" class="w-8 h-8 hover:bg-gray-50 cursor-pointer rounded-full transition">
            <x-bootstrap-icons icon="photo" class="h-4 mx-auto mt-2" />
        </label>
    @endif
    <div class="w-8 h-8 hover:bg-gray-50 cursor-pointer rounded-full transition">
        <x-bootstrap-icons x-on:click="$wire.uploadComment"  icon="send" width="32" height="32" class="h-4 w-4 ms-1 mt-2 rotate-45" />
    </div>
</div>

