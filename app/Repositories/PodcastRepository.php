<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\PodcastEpisodeDownload;

class PodcastRepository
{
    /**
     * A method which will show recent downloads of podcasts. which will give a grand total of numbers for how many times
     * items within podcasts have been downloaded.
     *
     * @return array
     */
    public static function recentDownloads(): array
    {
        // These types of query throw an error, count(*) would be a simpler method of handling this however, you'd
        // need to turn off full group by. which can be achieved in a multitude of ways, the better way being a
        // globalised edit to the ini file of mysql. other-wise you can utilise a query executor to set the session
        // of the full group by to none.
        DB::statement("SET SESSION sql_mode = ''");

        $podcastEpisodeDownloadGroups = PodcastEpisodeDownload::query()
            ->selectRaw(
                'count(podcast_episode_downloads.event_uuid) as downloads,' .
                'podcast_episode_downloads.occurred_at,'.
                'podcast_episode_downloads.podcast_uuid,' .
                'podcasts.name'
            )
            ->leftJoin(
                'podcasts',
                'podcasts.uuid',
                '=',
                'podcast_episode_downloads.podcast_uuid'
            )
            ->last7Days()
            ->groupBy([
                'podcast_episode_downloads.podcast_uuid',
                'podcast_episode_downloads.occurred_at'
            ])
            ->get();

        $podcastEpisodesDownloaded = [];

        foreach ($podcastEpisodeDownloadGroups as $podcastEpisodeDownloadGroup) {
            $key1 = $podcastEpisodeDownloadGroup->podcast_uuid;
            $key2 = $podcastEpisodeDownloadGroup->occurred_at->format('Y-m-d');

            // if we haven't yet accounted for this particular combination of podcast as well as day; then we're going
            // to set it and continue on with the loop; otherwise ignore this block and then begin adding onto the total
            // calculation.
            if (! isset($podcastEpisodesDownloaded[$key1][$key2])) {
                $podcastEpisodesDownloaded[$key1][$key2] = $podcastEpisodeDownloadGroup->downloads;
                continue;
            }

            $podcastEpisodesDownloaded[$key1][$key2] += $podcastEpisodeDownloadGroup->downloads;
        }

        return $podcastEpisodesDownloaded;
    }
}
