<?php

use function Livewire\Volt\{state};

state([
    "comment",
    "content" => fn() => $this->comment->content
]);

$save = function () {
    $this->comment->update([
        'content' => $this->content
    ]);

    $this->redirect(request()->header("Referer"));
}

?>

<div>
    <textarea wire:model='content' class="w-full bg-transparent hover:ring-0 border-gray-200" name=""></textarea>
    <div class="flex gap-2 justify-end">
        {{-- <div x-on:click="$wire.toggleEdit" class="px-2 py-1 font-bold text-sm text-center mt-1 cursor-pointer bg-white rounded border border-white hover:border-gray-200 transition">
            Cancel
        </div> --}}
        <div x-on:click="$wire.save" class="px-2 py-1 font-bold text-sm text-center mt-1 cursor-pointer bg-black rounded text-white hover:bg-neutral-700 transition">
            Save
        </div>
    </div>
</div>
