<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(),
            // "slug" => $this->faker->slug($title),
            "meta_description" => $this->faker->paragraph(1),
            // "meta_keywords",
            // "tags",
            "cover_image" => $this->faker->imageUrl(),
            "body" => $this->faker->paragraph(1),
            "status" => $this->faker->numberBetween(0, 1),
            "user_id" => User::all()->random()->id,
            // "categories_id" => Category::all()->random()->id,
        ];
    }
}
