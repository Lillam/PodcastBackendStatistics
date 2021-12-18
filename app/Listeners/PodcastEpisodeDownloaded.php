<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Models\PodcastEpisodeDownload;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PodcastEpisodeDownloaded as PodcastEpisodeDownloadedEvent;

class PodcastEpisodeDownloaded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PodcastEpisodeDownloadedEvent  $event
     * @return void
     */
    public function handle(PodcastEpisodeDownloadedEvent $event)
    {
        PodcastEpisodeDownload::create([
            'event_uuid' => Str::uuid(),
            'podcast_uuid' => $event->podcastEpisode->podcast_uuid,
            'podcast_episode_uuid' => $event->podcastEpisode->uuid,
            'occurred_at' => now()
        ]);
    }
}
