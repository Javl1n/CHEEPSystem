<?php

use function Livewire\Volt\{state, usesFileUploads};

usesFileUploads();

state([
    'receiver',
    'content',
    'image'
]);

$clearImage = fn () => $this->image = '';


$sendMessage = function () {
    $this->validate([
        'content' => 'required'
    ]);
    $message = $this->receiver->messagesReceived()->create([
        'sender_id' => auth()->user()->id,
        'content' => $this->content
    ]);

    if($this->image) {
        $this->validate([
            'image' => 'image'
        ]);
        $message->file()->create([
            'url' => $this->image->store('images/messages')
        ]);
    }

    $this->redirect(request()->header('Referer'), navigate: true);
    // $this->content = '';
    // $this->image = '';

    // $this->dispatch('send');
};

?>

<div class="bg-white pb-2 pt-3 px-3 flex gap-2 absolute bottom-1 w-3/4">
    <div class="flex flex-col justify-end py-2">
        @if(!$this->image)
            <label for="image" class="w-6 h-6 hover:bg-gray-50 cursor-pointer rounded-full transition">
                <x-bootstrap-icons icon="photo" class="h-5" />
            </label>
        @endif
        <input type="file" class="hidden" id="image" wire:model='image'>
    </div>
    <div class="flex-1 bg-gray-100 rounded-3xl">
        @if ($this->image)
            <div class="flex gap-2 px-2 py-2">
                <img src="{{ $this->image->temporaryUrl() }}" class="max-h-32 rounded-xl">
                <div>
                    <x-bootstrap-icons x-on:click="$wire.clearImage" icon="x" class="h-6 bg-gray-200 cursor-pointer hover:bg-gray-300 rounded-full transition" />
                </div>
            </div>
        @endif
        <textarea
            class="resize-none h-8 rounded-3xl bg-gray-100 w-full px-3 pt-1 pb-2 text-md border-transparent focus:border-transparent overflow-hidden focus:ring-0"
            x-data="{
                resize: () => {
                    $el.style.height = '1px';
                    $el.style.height = $el.scrollHeight + 'px'
                }
            }"
            x-init="resize()"
            x-on:input="resize()"
            wire:model='content'
            placeholder="Aa"
            x-transition
            required
        ></textarea>
        {{-- <x-input-error :messages="$errors->get('content')" class="" /> --}}
    </div>
    <div class="flex flex-col justify-end py-2">
        <div wire:click='sendMessage' for="image" class="w-6 h-6 hover:bg-gray-50 cursor-pointer rounded-full transition">
            <x-bootstrap-icons icon="send" class="h-5 rotate-45" />
        </div>
    </div>
</div>