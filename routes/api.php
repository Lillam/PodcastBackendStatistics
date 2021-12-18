<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PodcastController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/recent-downloads/v1', [PodcastController::class, 'recentDownloadsv1'])
    ->name('podcasts.recent-downloads.1');

Route::get('/recent-downloads/v2', [PodcastController::class, 'recentDownloadsv2'])
    ->name('podcasts.recent-downloads.2');
