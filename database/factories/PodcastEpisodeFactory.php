<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Podcast;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastEpisodeFactory extends Factory
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
            // the factory, naturally by default returns the primaryKey of the model. which you will be able to find
            // the primary key field against the podcast model.
            'podcast_uuid' => Podcast::factory(),
            'name' => $this->faker->name,
            // the factory, naturally by default returns the primaryKey of the model. which you will be able to find
            // the primary key field against the user model.
            'created_by_uuid' => User::factory(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
