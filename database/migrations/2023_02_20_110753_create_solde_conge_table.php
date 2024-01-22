<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldeCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solde_conge', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('annee');
            $table->float('solde_consome')->default(0);
            $table->float('solde')->default(0);
            $table->unsignedBigInteger('collaborateur_id')->nullable();
            $table->foreign('collaborateur_id')->references('id')->on('collaborateurs')->onDelete('set null');
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
        Schema::dropIfExists('solde_conge');
    }
}
