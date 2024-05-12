<?php

use function Livewire\Volt\{state, rules};

use App\Models\PollVote;

state([
    'password' => ''
]);

rules(['password' => ['required', 'string', 'current_password']]);

$resetPolls = function () {
    $this->validate();

    PollVote::truncate();

    $this->redirect(request()->header('Referer'), navigate: true);
}

?>

<x-modal name="confirm-poll-reset" :show="$errors->isNotEmpty()" focusable>
    <form wire:submit="resetPolls" class="p-6">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to reset all polls?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('This operation is only recommended after the current year\'s polls have ended. Please enter your password to confirm you would like to reset the polls.') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                wire:model="password"
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Reset Polls') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
