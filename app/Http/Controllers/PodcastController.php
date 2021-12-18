<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;
use App\Events\PodcastDownloaded;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PodcastEpisodeDownload;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class PodcastController extends Controller
{
    /**
     * Return a display of the podcasts that we have in the system.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $podcasts = Podcast::query()
            ->with([
                'created_by',
                'episodes'
            ])
            ->whereHas('episodes')
            ->paginate(4);

        return view('welcome', compact(
            'podcasts'
        ));
    }

    /**
     * @param Podcast $podcast
     * @return void
     */
    public function show(Podcast $podcast): void
    {
        // here we could potentially show the contents of a podcast, however out of the scope for what is really
        // necessary with the tech-test.
        // we could do a variety of things here when we return this to the view, potentially even loading the relationships
        // of the podcast.
        $podcast->load('created_by', 'episodes'); // as an example.
        dd($podcast);
    }

    /**
     * A method of which will show all the downloads (recent) within the last 7 days; ultimately this would be named
     * more conveniently to something that it does SPECIFICALLY however this could potentially be utilised for showing
     * downloads within the last (x) and the (x) of which provided would be your point in time to, so it could potentially
     * be a limitation to this method to only be pre-defined as 7 days ago.
     *
     * @return JsonResponse
     */
    public function recentDownloadsv1(): JsonResponse
    {
        // dirty cheap way to do it, but the simplistic method for saving time.
        DB::statement("SET SESSION sql_mode = ''");

        // These types of query throw an error, count(*) would be a simpler method of handling this however, you'd
        // need to turn off full group by. which can be achieved in a multitude of ways, the better way being a
        // globalised edit to the ini file of mysql. other-wise you can utilise a query executor to set the session
        // of the full group by to none.
        return response()->json([
            'data' => PodcastEpisodeDownload::query()
                ->selectRaw('count(event_uuid) as downloads, occurred_at')
                ->last7Days()
                ->groupBy('occurred_at')
                ->get()
                ->map(function ($eventGroup) {
                    // the occurrence being X and the downloads being Y. flipping these will give you a different style
                    // of a time series format.
                    // this could be made a little more obvious for the consumption of a frontend API for instance:
                    // apexcharts would require this to be:
                    // return ['x' => $eventGroup->occurred_at->format('Y-m-d'), 'y' => $eventGroup->downloads];
                    return [$eventGroup->occurred_at->format('Y-m-d') => $eventGroup->downloads];
                }),
        ]);
    }

    /**
     * Version 2 of the above, more so dedicated towards getting all of the podcasts aggregated by episode, as well as
     * by day, to see how many total downloads per podcast per day.
     *
     * @return JsonResponse
     */
    public function recentDownloadsv2(): JsonResponse
    {
        // dirty cheap way to do it, but the simplistic method for saving time.
        DB::statement("SET SESSION sql_mode = ''");

        return response()->json([
            'data' => PodcastEpisodeDownload::query()
                ->selectRaw(
                    'count(podcast_episode_downloads.event_uuid) as downloads,' .
                    'podcast_episode_downloads.occurred_at,'.
                    'podcast_episode_downloads.event_uuid,' .
                    'podcast_episodes.name'
                )
                ->leftJoin(
                    'podcast_episodes',
                    'podcast_episodes.uuid',
                    '=',
                    'podcast_episode_downloads.podcast_episode_uuid'
                )
                ->last7Days()
                ->groupBy([
                    'podcast_episode_downloads.podcast_episode_uuid',
                    'podcast_episode_downloads.occurred_at'
                ])
                ->get()
                ->map(function ($eventGroup) {
                    return [
                        $eventGroup->name => [
                            [$eventGroup->occurred_at->format('Y-m-d') => $eventGroup->downloads]
                        ]
                    ];
                })
        ]);
    }

    /**
     * basically the same as above, however aggregated to podcasts and then by day. and returning results of each.
     *
     * @return JsonResponse
     */
    public function recentDownloadsv3(): JsonResponse
    {
        // dirty cheap way to do it, but the simplistic method for saving time.
        DB::statement("SET SESSION sql_mode = ''");

        return response()->json([
            'data' => PodcastEpisodeDownload::query()
                ->selectRaw('count(event_uuid) as downloads, occurred_at, podcast_uuid')
                ->last7Days()
                ->groupBy(['podcast_uuid', 'occurred_at'])
                ->get()
                ->map(function ($eventGroup) {
                    // the occurrence being X and the downloads being Y. flipping these will give you a different style
                    // of a time series format.
                    // this could be made a little more obvious for the consumption of a frontend API for instance:
                    // apexcharts would require this to be:
                    // return ['x' => $eventGroup->occurred_at->format('Y-m-d'), 'y' => $eventGroup->downloads];
                    return [
                        $eventGroup->podcast_uuid => [
                            $eventGroup->occurred_at->format('Y-m-d') => $eventGroup->downloads
                        ]
                    ];
                })
        ]);
    }

    /**
     * @param Request $request
     * @param Podcast $podcast
     * @return RedirectResponse
     */
    public function download(Request $request, Podcast $podcast): RedirectResponse
    {
        event(new PodcastDownloaded($podcast));

        return back();
    }
}
