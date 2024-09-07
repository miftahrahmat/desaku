<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 1000),
            'body' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->sentence(),
            'author_id' => 1,
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 years', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
