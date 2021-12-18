<?php

namespace Database\Factories;

use App\Models\Podcast;
use Illuminate\Support\Str;
use App\Models\PodcastEpisode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastEpisodeDownloadFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'event_uuid' => Str::uuid(),
            'podcast_episode_uuid' => PodcastEpisode::factory(),
            'podcast_uuid' => Podcast::factory(),
            'occurred_at' => now()
        ];
    }
}
