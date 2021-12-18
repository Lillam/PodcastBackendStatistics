<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_episodes', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('podcast_uuid');
            $table->uuid('created_by_uuid');
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::table('podcast_episodes', function (Blueprint $table) {
            $table->foreign('podcast_uuid')
                ->references('uuid')
                ->on('podcasts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('created_by_uuid')
                ->references('uuid')
                ->on('users')
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
