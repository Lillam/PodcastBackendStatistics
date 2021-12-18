<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastEpisodeDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_episode_downloads', function (Blueprint $table) {
            $table->uuid('event_uuid')->primary();
            $table->uuid('podcast_uuid');
            $table->uuid('podcast_episode_uuid');
            $table->dateTime('occurred_at');
        });

        Schema::table('podcast_episode_downloads', function (Blueprint $table) {
            $table->foreign('podcast_uuid')
                ->references('uuid')
                ->on('podcasts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('podcast_episode_uuid')
                ->references('uuid')
                ->on('podcast_episodes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // essentially what we'd want to do here, reverse everything that this particular migration had done.
        // specifically due to time constrains, and being a task, there's no real need to do this.
    }
}
