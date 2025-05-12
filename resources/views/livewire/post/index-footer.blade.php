<?php

use function Livewire\Volt\{state, computed};

state([
    'post',
    'liked' => fn() => $this->post->likes->where('user_id', auth()->user()->id)->first() ? true : false
]);

$like = function () {
    // check if auth likes the forum
    $like = $this->post->likes->where('user_id', auth()->user()->id)->first();
    if(! $like) {
        // remove from db if liked
        $this->post->likes()->create([
            'user_id' => auth()->user()->id
        ]);
    } else {
        $like->delete();
    }

    $this->redirect(request()->header("Referer"));
    // add to db if not liked
};

$likes = computed(function () {
    return $this->post->likes->count();
});

$commentCount = computed(function ($comment) {
    if ($comment->comments->count() == 0) {
        return 1;
    }

    foreach($comment->comments as $commentChild) {
        return 1 + $this->commentCount($commentChild);
    }
});

$comments = computed(function () {
    return $this->commentCount($this->post);
})

?>

<div class="mx-5 flex gap-2 py-2 font-bold text-neutral-500">
    {{-- reactions --}}
    <div x-on:click="$wire.like" @class([
        "flex gap-2 rounded-xl hover:bg-neutral-50 transition py-1 px-2 cursor-pointer",
        "text-red-500 hover:bg-red-50" => $this->liked
    ])>
        <x-bi-heart class="my-auto h-5 w-5" />
        <span class="my-auto">{{ $this->likes }}</span>
    </div>
    {{-- comments --}}
    <div class="flex gap-2 p-1">
        <x-bi-chat class="my-auto h-5 w-5" />
        <span class="my-auto">{{ $this->comments }}</span>
    </div>

</div>
