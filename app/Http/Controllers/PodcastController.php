<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;
use App\Events\PodcastDownloaded;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\PodcastRepository;
use App\Repositories\PodcastEpisodeRepository;
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
        return response()->json([
            'data' => PodcastEpisodeRepository::recentDownloads()
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
        return response()->json([
            'data' => PodcastRepository::recentDownloads()
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
