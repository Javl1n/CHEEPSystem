<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();
    $this->redirect('/', navigate: true);
};

?>

<div>
    <x-primary-button class="mt-10" wire:click='logout'>
        Log out
    </x-primary-button>
</div>

