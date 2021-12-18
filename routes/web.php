<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\PodcastEpisodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PodcastController::class, 'index'])
    ->name('podcasts.index');

Route::get('/podcasts/download/{podcast}', [PodcastController::class, 'download'])
    ->name('podcasts.download');

Route::get('/podcasts/{podcast}', [PodcastController::class, 'show'])
    ->name('podcasts.show');

Route::get('/podcasts/download/episode/{podcastEpisode}', [PodcastEpisodeController::class, 'download'])
    ->name('podcasts.episodes.download');

// there is possibilities of utilising Route::group('podcasts', function () { // the group here });
// in order for simplifying the urls. Taking the above approach for ease of creation.
