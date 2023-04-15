<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "SuperAdmin",
            "email" => "super-admin@mail.com",
            "password" => Hash::make("password"),
            'email_verified_at' => now(),
            "bio" => "I am Super Admin",
            'remember_token' => Str::random(10),
        ])->assignRole('super-admin');
        User::create([
            'name' => "Admin",
            "email" => "admin@mail.com",
            "password" => Hash::make("password"),
            'email_verified_at' => now(),
            "bio" => "I am Admin",
            'remember_token' => Str::random(10),
        ])->assignRole('admin');
        User::create([
            'name' => "Editor",
            "email" => "editor@mail.com",
            "password" => Hash::make("password"),
            'email_verified_at' => now(),
            "bio" => "I am Editor",
            'remember_token' => Str::random(10),
        ])->assignRole('editor');
        User::create([
            'name' => "Viewer",
            'email' => 'viewer@mail.com',
            'password'=> Hash::make("password"),
            'email_verified_at' => now(),
            "bio" => "I am Viewer",
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory(10)->create();
    }
}
