<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('game_number')->nullable();
            $table->integer('home_previous_game_id')->nullable();
            $table->integer('visiting_previous_game_id')->nullable();
            $table->string('round')->nullable();
            $table->string('race_to')->nullable();
            $table->string('home_score');
            $table->string('visiting_score');
            $table->unsignedBigInteger('home_id')->nullable();
            $table->string('home_type')->nullable();
            $table->unsignedBigInteger('visiting_id')->nullable();
            $table->string('visiting_type')->nullable();
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete("cascade");
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
