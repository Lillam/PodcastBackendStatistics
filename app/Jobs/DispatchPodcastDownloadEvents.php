<?php

namespace App\Jobs;

use App\Models\PodcastEpisode;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Events\PodcastEpisodeDownloaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchPodcastDownloadEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // here we should realistically check to see whether the database has been migrated, if not then this job
        // will automatically fail (specifically for the tech test; however this would be a general concern; if this job
        // has a possibility of running in an environment that has not yet been fully setup, then needs a failsafe
        // consideration).
        PodcastEpisode::chunk(10, function ($podcastEpisodes) {
            foreach ($podcastEpisodes as $podcastEpisode) {
                for ($i = 0; $i < rand(1, 3); $i++) {
                    event(new PodcastEpisodeDownloaded($podcastEpisode));
                }
            }
        });
    }
}
