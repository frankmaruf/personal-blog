<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        \App\Models\Category::create([
            "title" => "Sample",
            "meta_description" => "Sample Category"
        ]);
        \App\Models\Category::factory(10)->create();
        \App\Models\Blog::factory(50)->create();
    }
}
