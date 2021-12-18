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
        // to clarify some magic, what is happening here is that the podcast factory will create (10) and within each
        // 10 will create 10 podcast episodes, and within either of these factories, there will be a user that is created
        // in order to be assigned to both models.
        Podcast::factory(4)
            ->has(
                PodcastEpisode::factory(5)
                    ->has(
                        PodcastEpisodeDownload::factory(10)
                            // create a sequence in which all o the downloads of podcasts will be created. we are going
                            // to be seeding in the matter of 8 days out, so that there's a test and a succinct calculation
                            // that there will only be 7 days worth of data, and that some will be missed off; to see
                            // whether the aggregation of data is correct.
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
                            )),
                        'downloads'
                    )
                    ->state([ 'created_at' => Carbon::parse('2021-01-01') ]),
                'episodes'
            )
            ->state([ 'created_at' => Carbon::parse('2021-01-01') ])
            ->create();
    }
}
