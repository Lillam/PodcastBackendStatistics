<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name,
            'created_by_uuid' => User::factory(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
