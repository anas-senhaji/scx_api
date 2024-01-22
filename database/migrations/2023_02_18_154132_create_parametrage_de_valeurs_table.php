<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\eTypeParametrageDeValeur;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrageDeValeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametrage_de_valeurs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->enum('nom', eTypeParametrageDeValeur::getAll(eTypeParametrageDeValeur::class));
            $table->float('minimum')->nullable();
            $table->float('maximum')->nullable();
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
        Schema::dropIfExists('parametrage_de_valeurs');
    }
}
