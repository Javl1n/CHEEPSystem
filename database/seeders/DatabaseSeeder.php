<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Feature;
use App\Models\EvaluationQuestion;
use App\Models\UserVerificaiton;
use App\Models\File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('images');

        // User::factory(10)->create();
        $admin = Role::create([
            'name' => 'Admin'
        ]);

        $admin->users()->create([
            'name' => 'Frank Leimbergh D. Armodia',
            'email' => 'farmodia@gmail.com',
            'password' => Hash::make('admin123'),
        ])->profile()->create([
            'url' => 'storage/images/empty_profile.jpg'
        ]);
        
        $teacher = Role::create([
            'name' => 'Teacher'
        ]);
        
        $student = Role::create([
            'name' => 'Student'
        ]);

        Feature::create([
            'title' => 'Evaluation',
        ]);

        Feature::create([
            'title' => 'Voting',
        ]);

        $teacherUser = $teacher->users()->create([
            'name' => 'Ferdinand Cabigting Jr.',
            'email' => 'sam@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        $teacherUser->verification()->create([
            'verified' => true,
        ])->file()->create([
            'url' => 'storage/images/bg-school.jpg',
        ]);
        
        $teacherUser->profile()->create([
            'url' => 'storage/images/empty_profile.jpg'
        ]);

        $studentUser = $student->users()->create([
            'name' => 'Kryz John F. Luceno',
            'email' => 'kryz@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        $studentUser->verification()->create([
            'verified' => true,
        ])->file()->create([
            'url' => 'storage/images/bg-school.jpg',
            
        ]);

        $studentUser->profile()->create([
            'url' => 'storage/images/empty_profile.jpg'
        ]);

        foreach([$student, $teacher] as $role) {
            User::factory(15)
            ->create([
                'role_id' => $role->id,
            ])->map(function ($user) {
                $user->verification()->create([
                    'verified' => true,
                ])->file()->create([
                    'url' => 'storage/images/bg-school.jpg',
                ]);
                $user->profile()->create([
                    'url' => 'storage/images/empty_profile.jpg'
                ]);
            });
        }

        $this->call([
            PollSeeder::class,
            EvaluationSeeder::class,
        ]);   
    }
}
