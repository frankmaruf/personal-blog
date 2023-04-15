<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->sentence,
            "cover_photo" => $this->faker->imageUrl,
            "sort_description" => $this->faker->paragraph(1),
            "description" => $this->faker->paragraph(3),
            "live" => $this->faker->imageUrl,
            "source_code" => $this->faker->imageUrl,
        ];
    }
}
