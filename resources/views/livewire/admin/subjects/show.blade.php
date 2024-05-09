<?php

use function Livewire\Volt\{state};

state([
    'subject'
])

?>

<div class="">
    <div x-on:click.prevent="$dispatch('open-modal', 'edit-subject-{{ $subject->id }}')" class="border shadow rounded-lg hover:bg-gray-100 cursor-pointer py-4 transition h-36 flex flex-col justify-center">
        <div class="text-center text-2xl font-bold">{{ $subject->code }}</div>
        <div class="text-center text-md px-2 mt-2 font-bold">{{ $subject->name }}</div>
    </div>
    @livewire('admin.subjects.edit', ['subject' => $subject])
</div>
