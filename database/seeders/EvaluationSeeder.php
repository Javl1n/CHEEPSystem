<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EvaluationQuestion;
use App\Models\EvaluationTaken;
use App\Models\EvaluationScore;
use App\Models\User;
use App\Models\Subject;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = EvaluationQuestion::factory(15)->create();

        $teachers = User::where('role_id', 2)->get();
        $students = User::where('role_id', 3)->get()->reject(function ($value, int $key) {
            return $value->email === "kryz@gmail.com";
        });

        Subject::factory(15)->create();

        foreach($teachers as $teacher) {
            foreach ($students as $student) {
                $evaluation = $student->studentEvaluations()->create([
                    'teacher_id' => $teacher->id,
                    'subject_id' => fake()->numberBetween(1, 15),
                    'answered' => true
                ]);
                foreach ($questions as $question) {
                    $evaluation->scores()->create([
                        'question_id' => $question->id,
                        'score' => fake()->numberBetween(1, 5)
                    ]);
                }
            }
        }

    }
}
