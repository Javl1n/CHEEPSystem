<?php

use function Livewire\Volt\{state, computed};
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;


state([
    'teachers' => User::where('role_id', 2)->whereHas('verification', function (Builder $query) {
        $query->where('verified', true);
    })->with('teacherEvaluations.scores')->get()
]);

$score = computed(function($teacher) {
    $totalScore = 0;
    $total = 0;
    foreach ($teacher->teacherEvaluations as $evaluation) {
        foreach($evaluation->scores as $score) {
            $totalScore += $score->score;
            $total += 5;
        }
    }
    $percent = 0;

    if($total !== 0) {
        $percent = round( $totalScore / $total * 100 , 0);
    }

    return $percent; 
});

?>

<div>
    <h1 class="text-lg font-bold">{{ __("Verified Teachers") }}</h1>
    <div class="h-[calc(100vh-300px)] overflow-auto mt-4 no-scrollbar">
        @foreach ($teachers as $teacher)
            <div 
            style="
                background-image: linear-gradient(to right, #fee2e2 {{ $this->score($teacher) }}%, white 0%);
                border-width: 1px;
            "
            @class([
                "flex p-2 rounded gap-2",
                "mt-2" => !$loop->first
            ])>
                <x-profile-picture :src="asset($teacher->profile->url)" class="h-12 shadow-md" />
                <div class="flex flex-col justify-center">
                    <h1 class="font-bold">{{ $teacher->name }}</h1>
                    <h2>Score: {{ $this->score($teacher) }}%</h2>
                </div>
            </div>
        @endforeach
    </div>
</div>
