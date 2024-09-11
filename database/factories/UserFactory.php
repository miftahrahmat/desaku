<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Your Name',
            'email' => 'admin@admin.com',
            'role'  => 'admin',
            'email_verified_at' => 'null',
            'password' => 'admin123',
            'remember_token' => Str::random(10),
        ];
    }
}
