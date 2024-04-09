<?php

use function Livewire\Volt\{state, rules, usesFileUploads};
use Illuminate\Support\Facades\Storage;

usesFileUploads();

state([
    'photo',
    'user' => auth()->user()
]);

rules([
    'photo' => 'required|image',
]);

$updateProfile = function () {
    $this->validate();

    if ($this->user->profile->url !== 'storage/images/empty_profile') {
        Storage::delete($this->user->profile->url);
    }

    $this->user->profile->update([
        'url' => $this->photo->store('images/profiles')
    ]);

    return redirect('profile');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Picture') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <img class="mx-auto w-60 aspect-square object-cover mt-1 rounded-lg border shadow" src="{{ asset(auth()->user()->profile->url) }}" alt="">
                <div class="text-center text-xs mt-1 text-gray-500">
                    Current Profile
                </div>
            </div>
            <div class="w-60 h-60">
                <x-image-upload model="photo" />
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>
            
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:click='updateProfile'>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </div>
</section>