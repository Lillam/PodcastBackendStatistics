<?php

namespace App\Listeners;

use App\Events\PodcastEpisodeDownloaded;
use App\Events\PodcastDownloaded as PodcastDownloadedEvent;

class PodcastDownloaded
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
     * This event is a wrap of the entire podcast, what this will inevitably do is iterate over all the episodes that
     * reside inside a podcast, and ship out an individual event.
     *
     * @param  PodcastDownloadedEvent  $event
     * @return void
     */
    public function handle(PodcastDownloadedEvent $event)
    {
        // we alternatively could do something entirely different with downloading the entire podcast, however, all the
        // episodes that reside inside a podcast, make sense to send out a singular event for each one. this is more so
        // a nice to have feature for a user; so they don't need to keep downloading one by one, but have a process that
        // downloads them all and highlights to the system that they had all been downloaded.

        // could potentially have another column which then records how many times ALL podcasts had been downloaded
        // at once.
        foreach ($event->podcast->episodes as $episode) {
            event(new PodcastEpisodeDownloaded($episode));
        }
    }
}
