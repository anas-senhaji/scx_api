<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorodatagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horodatages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->morphs('model');
            $table->enum('action', ['ADD', 'UPDATE', 'DELETE']);
            $table->json('old_data')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('horodatages');
    }
}
