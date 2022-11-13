<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            "about_your_self" => "I am Super Admin"
        ])->assignRole('super-admin');
        User::create([
            'name' => "Admin",
            "email" => "admin@mail.com",
            "password" => Hash::make("password"),
            'email_verified_at' => now(),
            "about_your_self" => "I am Admin"
        ])->assignRole('admin');
        User::create([
            'name' => "Editor",
            "email" => "editor@mail.com",
            "password" => Hash::make("password"),
            'email_verified_at' => now(),
            "about_your_self" => "I am Editor"
        ])->assignRole('editor');
        User::create([
            'name' => "Viewer",
            'email' => 'viewer@mail.com',
            'password'=> Hash::make("password"),
            'email_verified_at' => now(),
            "about_your_self" => "I am Viewer"
        ]);
    }
}
