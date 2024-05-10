<?php

use function Livewire\Volt\{state, mount};


state([
    'polls',
    'votes'
]);

mount(function () {
    $this->votes = $this->polls->map(function ($item, $key){
        return ['poll-' . $item->id => ''];
    })->flatMap(function (array $values) {
        return $values;
    });
    // ddd($this->votes['question-' . 2]);
});

$selectOption = function ($pollId, $optionId) {
    $this->votes['poll-' . $pollId] = $optionId; 
};

$submit = function () {
    foreach($this->polls as $poll) {
        if (!empty($this->votes['poll-' . $poll->id])) {
            auth()->user()->studentVotes()->create([
                'option_id' => $this->votes['poll-' . $poll->id]
            ]);
        }
    }

    $this->redirect(request()->header('Referer'), navigate: true);
}

?>

<div>
    @foreach ($polls as $poll)    
        <div wire:key='poll-form-{{ $poll->id }}' class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                <h1 class="text-xl font-bold">{{ $poll->description }}</h1>
                <div class="mt-4">
                    @foreach ($poll->options as $option)
                        <div
                        wire:key='option-form-{{ $option->id }}'
                        wire:click='selectOption({{ $poll->id }}, {{ $option->id }})'
                        @class([
                            "px-2 py-2 text-lg font-bold mt-2 border rounded shadow-sm transition",
                            "cursor-pointer hover:bg-red-200" => $this->votes['poll-' . $poll->id] !== $option->id,
                            "bg-red-500 text-white" => $this->votes['poll-' . $poll->id] === $option->id,
                        ])>
                            {{ $option->description }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <div class="mt-10 flex justify-center">
        <x-primary-button wire:click='submit'>
            Submit
        </x-primary-button>
    </div>
</div>
