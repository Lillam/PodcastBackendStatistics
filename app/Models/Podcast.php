<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Podcast extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'podcasts';

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
        'created_by',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Each podcast in the system has a possibility of having many episodes. this method will return a relationship
     * collection full of episodes.
     *
     * @return HasMany
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(PodcastEpisode::class, 'podcast_uuid', 'uuid');
    }

    /**
     * Episodes of podcasts can be downloaded, this method is more so a helper method which will enable the
     * knowledge of how many times a podcast has had items downloaded inside itself via the utilisation of
     * relationships.
     *
     * @return HasMany
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(PodcastEpisodeDownload::class, 'podcast_uuid', 'uuid');
    }

    /**
     * Each podcast in the system has to have been made by someone, someone owns the podcast and maintains it, this
     * is a relationship method to acquire the user it belongs to.
     *
     * @return BelongsTo
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_uuid', 'uuid');
    }
}
