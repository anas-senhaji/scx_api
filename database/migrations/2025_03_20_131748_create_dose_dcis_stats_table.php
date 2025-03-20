<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoseDcisStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dose_dcis_stats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('date');
            $table->float('consommation')->nullable();
            $table->float('prevision')->nullable();
            $table->float('ecart')->nullable();
            $table->unsignedBigInteger('dose_dcis_id')->nullable();
            $table->string('fullname');
            $table->foreign('dose_dcis_id')->references('id')->on('dose_dcis')->onDelete("SET NULL");
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
        Schema::dropIfExists('dose_dcis_stats');
    }
}
