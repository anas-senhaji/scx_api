<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlcStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulc_statistics', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('date');
            $table->float('stock_image')->nullable();
            $table->float('nbr_produits_perimes')->nullable();
            $table->float('nbr_proche_perimes')->nullable();
            $table->float('capacite')->nullable();
            $table->float('taux_occupation')->nullable();
            $table->float('taux_peremption')->nullable();
            $table->float('taux_proche_perime')->nullable();
            $table->float('taux_rupture')->nullable();
            $table->float('taux_proche_penuerie')->nullable();
            $table->float('taux_disponibilite_a')->nullable();
            $table->float('taux_disponibilite_b')->nullable();
            $table->float('taux_disponibilite_c')->nullable();
            $table->unsignedBigInteger('ulc_id')->nullable();
            $table->foreign('ulc_id')->references('id')->on('ulcs')->onDelete("SET NULL");
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
        Schema::dropIfExists('ulc_statistics');
    }
}
