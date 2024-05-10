<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role_id', 3)->get()->reject(function ($value, int $key) {
            return $value->email === "kryz@gmail.com";
        });

        $polls = Poll::factory(10)->create();

        foreach($polls as $poll) {
            $options = PollOption::factory(4)->create([
                'poll_id' => $poll->id
            ]);
            // dd($options->pluck('id'));

            foreach($students as $student) {
                PollVote::create([
                    'user_id' => $student->id,
                    'option_id' => fake()->randomElements($options->pluck('id')->all())[0]
                ]);
            }
        }
    }
}
