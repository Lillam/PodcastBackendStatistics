<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Podcast;
use App\Models\PodcastEpisode;
use Illuminate\Database\Seeder;
use App\Models\PodcastEpisodeDownload;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Podcast::factory(4)->create();

        foreach (Podcast::all() as $podcast) {
            PodcastEpisode::factory(5)
                ->has(
                    PodcastEpisodeDownload::factory(10)
                        ->state(new Sequence(
                            ['occurred_at' => Carbon::now()->subDays(8)],
                            ['occurred_at' => Carbon::now()->subDays(8)],
                            ['occurred_at' => Carbon::now()->subDays(7)],
                            ['occurred_at' => Carbon::now()->subDays(6)],
                            ['occurred_at' => Carbon::now()->subDays(5)],
                            ['occurred_at' => Carbon::now()->subDays(4)],
                            ['occurred_at' => Carbon::now()->subDays(3)],
                            ['occurred_at' => Carbon::now()->subDays(2)],
                            ['occurred_at' => Carbon::now()->subDay()],
                            ['occurred_at' => Carbon::now()]
                        ))
                        ->state([
                            'podcast_uuid' => $podcast->uuid
                        ]),
                    'downloads'
                )
                ->state([
                    'podcast_uuid' => $podcast->uuid,
                    'created_at' => Carbon::parse('2021-01-01')
                ])
                ->create();
        }
    }
}
