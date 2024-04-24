<?php

use function Livewire\Volt\{state, layout, title};

layout('layouts.app');

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
</div>
