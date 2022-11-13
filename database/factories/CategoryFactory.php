<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->title,
            // "slug",
            // meta_keywords,
            // parent_id
            "meta_description" => $this->faker->sentence,
            "cover_image" => $this->faker->imageUrl,
            // "body" => $this->faker->paragraph(1),
            // "parent_id" => Category::all()->random()->id,
            "parent_id" => Category::all()->random()->id
        ];
    }
}
