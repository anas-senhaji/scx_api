<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmmcStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ummc_statistics', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('date');
            $table->float('nbr_consultation')->nullable();
            $table->float('nbr_medicament_prescrit')->nullable();
            $table->float('nbr_prescription')->nullable();
            $table->float('taux_prescription')->nullable();
            $table->float('nbr_dispentation')->nullable();
            $table->float('taux_adoption')->nullable();
            $table->float('nbr_medicament_dispense')->nullable();
            $table->float('taux_couverture')->nullable();
            $table->float('moyen_medicament_par_prescription')->nullable();
            $table->float('capacite')->nullable();
            $table->float('stock')->nullable();
            $table->float('taux_occupation')->nullable();
            $table->float('taux_peremption')->nullable();
            $table->float('taux_proche_perime')->nullable();
            $table->float('taux_rupture')->nullable();
            $table->float('taux_proche_penuerie')->nullable();
            $table->float('taux_disponibilite_a')->nullable();
            $table->float('taux_disponibilite_b')->nullable();
            $table->float('taux_disponibilite_c')->nullable();
            $table->unsignedBigInteger('ummc_id')->nullable();
            $table->foreign('ummc_id')->references('id')->on('ummcs')->onDelete("SET NULL");
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
        Schema::dropIfExists('ummc_statistics');
    }
}
