<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Podcast;
use App\Models\PodcastEpisode;
use App\Events\PodcastDownloaded;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PodcastDownloadedEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function will_download_and_log_to_database()
    {
        /** @var Podcast $podcast */
        $podcast = Podcast::factory()
            ->has(PodcastEpisode::factory(10), 'episodes')
            ->create();

        event(new PodcastDownloaded($podcast));

        $this->assertEquals(10, $podcast->downloads->count());
    }
}
