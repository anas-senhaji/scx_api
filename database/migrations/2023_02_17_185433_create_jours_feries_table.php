<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoursFeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jours_feries', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('nom');
            $table->string('jour');
            $table->string('mois');
            $table->string('annee')->nullable();
            $table->boolean('fixe')->default(false);
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
        Schema::dropIfExists('jours_feries');
    }
}
