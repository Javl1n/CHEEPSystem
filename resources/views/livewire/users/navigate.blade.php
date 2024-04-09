<?php

use function Livewire\Volt\{state};

?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h1 class="font-bold">{{ __("Navigate") }}</h1>
        <a wire:click=''>
            <div class="mt-4 ps-2 py-1 border-l-2 border-transparent hover:border-red-300 hover:text-red-600 transition ease-linear">
                <p class="text-sm">All</p>
            </div>
        </a>
    </div>
</div>
