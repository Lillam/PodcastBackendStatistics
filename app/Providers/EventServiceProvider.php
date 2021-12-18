<?php

namespace App\Providers;

use App\Events\PodcastDownloaded as PodcastDownloadedEvent;
use App\Listeners\PodcastDownloaded as PodcastDownloadedListener;
use App\Events\PodcastEpisodeDownloaded as PodcastEpisodeDownloadEvent;
use App\Listeners\PodcastEpisodeDownloaded as PodcastEpisodeDownloadListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PodcastDownloadedEvent::class => [
            PodcastDownloadedListener::class
        ],
        PodcastEpisodeDownloadEvent::class => [
            PodcastEpisodeDownloadListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
