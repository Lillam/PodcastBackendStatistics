<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PodcastEpisode extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'podcast_episodes';

    /**
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'podcast_uuid',
        'created_by'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'uuid' => 'string',
        'podcast_uuid' => 'string',
        'name' => 'string',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Every podcast episode that enters the system has to belong to a podcast overall wrapper.
     *
     * @return BelongsTo
     */
    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class, 'podcast_uuid', 'uuid');
    }

    /**
     * Each podcast episode in the system has to have been made by someone, someone owns the podcast and maintains it,
     * this is a relationship method to acquire the user it belongs to.
     *
     * @return BelongsTo
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_uuid', 'uuid');
    }

    /**
     * Each podcast in the system has a potential of being downloaded, this will provide the necessary functionality to
     * map the relationship to the episode, and collect a count or even all of the events if necessary.
     *
     * @return HasMany
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(PodcastEpisodeDownload::class, 'podcast_episode_uuid', 'uuid');
    }
}
