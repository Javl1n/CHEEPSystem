<?php

use function Livewire\Volt\{state};

state([
    'post',
    'commentsCount' => fn() => $this->post->comments()->count()
]);

?>

<div class="mx-5 flex gap-4  py-4 font-medium text-neutral-500">
    {{-- reactions --}}
    <div class="flex gap-2">
        <x-bi-heart class="my-auto h-5 w-5 text-neutral-400" />
        <span class="my-auto">61</span>
    </div>
    {{-- comments --}}
    <div class="flex gap-2">
        <x-bi-chat class="my-auto h-5 w-5 text-neutral-400" />
        <span class="my-auto">{{ $this->commentsCount }}</span>
    </div>

</div>
