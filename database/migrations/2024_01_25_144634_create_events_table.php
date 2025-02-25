<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('picture')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('place');
            $table->boolean('is_finished')->default(false);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete("cascade");
            $table->unsignedBigInteger('discipline_id')->nullable();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete("cascade");
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete("cascade");
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
        Schema::dropIfExists('events');
    }
}
