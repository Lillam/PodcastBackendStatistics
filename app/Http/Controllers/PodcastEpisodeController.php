<?php

namespace App\Http\Controllers;

use App\Models\PodcastEpisode;
use Illuminate\Http\RedirectResponse;
use App\Events\PodcastEpisodeDownloaded;

class PodcastEpisodeController extends Controller
{
    /**
     * Download the Podcast episode.
     *
     * @param PodcastEpisode $podcastEpisode
     * @return RedirectResponse
     */
    public function download(PodcastEpisode $podcastEpisode): RedirectResponse
    {
        event(new PodcastEpisodeDownloaded($podcastEpisode));

        return back();
    }
}
