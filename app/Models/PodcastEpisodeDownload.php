<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PodcastEpisodeDownload extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'podcast_episode_downloads';

    /**
     * @var string
     */
    protected $primaryKey = 'event_uuid';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'event_uuid',
        'podcast_uuid',
        'podcast_episode_uuid',
        'occurred_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'podcast_uuid' => 'string',
        'podcast_episode_uuid' => 'string',
        'occurred_at' => 'datetime'
    ];

    /**
     * appended query scope, that allows us to return data that was made within the last 7 days. utility query helper
     * method without having to write the entire lot out again.
     *
     * @param Builder  $builder
     * @return void
     */
    public function scopeLast7Days(Builder $builder)
    {
        $builder->where(
            'podcast_episode_downloads.occurred_at',
            '>=',
            Carbon::now()->subWeek()->startOfDay()
        );
    }
}
