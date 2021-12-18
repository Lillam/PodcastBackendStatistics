<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('created_by_uuid');
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::table('podcasts', function (Blueprint $table) {
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
