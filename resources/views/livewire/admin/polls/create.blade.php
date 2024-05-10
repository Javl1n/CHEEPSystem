<?php

use function Livewire\Volt\{state, mount};

use App\Models\Poll;

state([
    'title',
    'optionCount' => 2,
    'options' => collect([0 => ""], [1 => ""])
]);

$addOption = function() {
    $this->optionCount++;
    $this->options = $this->options->merge([($this->optionCount - 1) => ""]);
};

$removeOption = function ($number) {
    $number--;
    $this->options = $this->options->reject(function ($value, int $key) use ($number) {
        return $key === $number;
    })->sortKeys()->values();
    $this->optionCount --;
};

$save = function () {
    $this->validate([
        'title' => 'required',
        // 'options.*' => 'required'
    ]);

    if (!empty($this->options)) {
        $poll = Poll::create([
            'description' => $this->title
        ]);
    }

    foreach($this->options as $option) {
        if(!empty($option)) {
            $poll->options()->create([
                'description' => $option,
            ]);
        }
    }
    ddd($poll->options->pluck('id'));

    $this->redirect(request()->header('Referer'), navigate: true);
};

?>

<div class="bg-white mb-6 overflow-hidden shadow-sm sm:rounded-lg" x-data="{open: true }">
    <div class="text-gray-900">
        <div class="p-6 flex justify-between border-b shadow-sm">
            <h1 class="font-bold">
                {{ __("Add A Poll") }}
            </h1>
            <span class="text-sm font-bold cursor-pointer" x-on:click="open =! open">
                <x-bootstrap-icons icon="x" class="transition linear h-5" x-bind:class="open ? '' : 'rotate-45'" />
            </span>
        </div>

        <div x-show="open" class="p-6" x-transition x-collapse>
            <h1 class="font-bold">Title: </h1>
            <div class="border-2 rounded py-6 px-2 mt-2">
                <textarea
                    class="resize-none h-10 w-full p-0 text-lg rounded border-transparent focus:border-transparent overflow-hidden focus:ring-0"
                    x-data="{
                        resize: () => { $el.style.height = '20px'; $el.style.height = $el.scrollHeight + 'px' }
                    }"
                    x-init="resize()"
                    x-on:input="resize()"
                    wire:model='title'
                    placeholder="What's the poll all about?"
                    x-transition
                    required
                ></textarea>
            </div>
            <x-input-error :messages="$errors->get('title')" class="" />
            <h1 class="font-bold mt-6">Options: </h1>
            @for ($count = 1; $count <= $optionCount; $count++)
                <div class="flex mt-4">
                    <x-text-input wire:model="options.{{ $count - 1 }}" class="block  w-full" placeholder="Option {{ $count }}" required/>
                    @if($optionCount > 2)
                        <div wire:click="removeOption({{ $count }})" class="h-10 w-10 flex mx-2 hover:bg-gray-50 hover:fill-red-500 cursor-pointer rounded-full">
                            <x-bootstrap-icons icon="trash-filled" class="mx-auto my-auto transition linear h-6" />
                        </div>
                    @endif
                </div>
                <x-input-error :messages="$errors->get('options.{{ $count - 1 }}')" class="" />
            @endfor
            <div x-on:click="$wire.addOption" class="mt-4 border-2 rounded-md flex justify-center py-2 hover:bg-gray-50 cursor-pointer transition">
                <div class="rounded-full py-2 fill-black">
                    <x-bootstrap-icons icon="plus-square-dotted" class="h-5 " />
                </div>
                <h1 class="text-sm font-bold p-2">Add option</h1>
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <x-primary-button wire:click.prevent='save' class="ms-3">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
