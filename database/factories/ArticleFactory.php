<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $created_at = $this->faker->dateTimeBetween('-3 day', '-1 day');
        $slug = Str::slug($title)."-".$created_at->getTimestamp();

        return [
            'title' => $title,
            'content' => $this->faker->paragraph,
            'category_id' => rand(1, 3),
            'user_id' => rand(1, 3),
            'created_at' => $created_at,
            'slug' => $slug,
        ];
    }
}
