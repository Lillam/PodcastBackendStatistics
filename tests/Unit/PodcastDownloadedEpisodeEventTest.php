<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PodcastEpisode;
use App\Events\PodcastEpisodeDownloaded;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PodcastDownloadedEpisodeEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function will_download_and_log_to_database()
    {
        /** @var PodcastEpisode $podcastEpisode */
        $podcastEpisode = PodcastEpisode::factory()->create();

        event(new PodcastEpisodeDownloaded($podcastEpisode));

        $this->assertEquals(1, $podcastEpisode->downloads->count());
    }
}
