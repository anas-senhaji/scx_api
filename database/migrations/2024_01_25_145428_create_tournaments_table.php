<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('picture')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('place')->nullable();
            $table->text('info')->nullable();
            $table->json('ranking_points')->nullable();
            $table->json('prize_money')->nullable();
            $table->unsignedBigInteger('tournament_type_id')->nullable();
            $table->foreign('tournament_type_id')->references('id')->on('tournament_types')->onDelete("cascade");
            $table->unsignedBigInteger('discipline_id')->nullable();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete("cascade");
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete("cascade");
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete("cascade");
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete("cascade");
            $table->boolean('is_activated')->default(true);
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
        Schema::dropIfExists('tournaments');
    }
}
