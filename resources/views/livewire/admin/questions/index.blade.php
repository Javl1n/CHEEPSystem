<?php

use function Livewire\Volt\{state, on};

state([
    'question',
    'loop',
    'viewState' => 'show'
]);

on([
    "editMode-{question.id}" => function () { return $this->viewState = 'edit';},
    "showMode-{question.id}" => function () { return $this->viewState = 'show';},
]);

?>

<div>
    <div @class([
        "bg-white overflow-hidden shadow-sm sm:rounded-lg",
        "mt-6" => !$loop->first
    ])>
        @if ($viewState === "show")   
            @livewire('admin.questions.show', ['question'=> $question])
        @elseif($viewState === "edit")
            @livewire('admin.questions.edit', ['question'=> $question])
        @endif
    </div>
</div>

