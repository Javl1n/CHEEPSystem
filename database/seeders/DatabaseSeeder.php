<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        Role::create([
            'name' => 'Teacher'
        ]);
        Role::create([
            'name' => 'Student'
        ]);
        $admin->users()->create([
            'name' => 'Frank Leimbergh Armodia',
            'email' => 'farmodia@gmail.com',
            'password' => Hash::make('admin123'),
        ])->file()->create([
            'url' => 'storage/images/empty_profile.png'
        ]);
    }
}
