<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
            'name' => 'Frank Leimbergh Armodia',
            'email' => 'farmodia@gmail.com',
            'password' => Hash::make('admin123'),
        ])->profile()->create([
            'url' => 'storage/images/empty_profile.png'
        ]);
        
        $teacher = Role::create([
            'name' => 'Teacher'
        ]);
        
        $student = Role::create([
            'name' => 'Student'
        ]);

        foreach([$student, $teacher] as $role) {
            User::factory(5)
            ->create([
                'role_id' => $role->id
            ])->map(function ($user) {
                $user->verification()->create()->file()->create([
                    'url' => 'storage/images/bg-school.jpg'
                ]);
                $user->profile()->create([
                    'url' => 'storage/images/empty_profile.png'
                ]);
            });
        }
    }
}
