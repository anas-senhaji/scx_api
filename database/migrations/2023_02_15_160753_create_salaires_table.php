<?php

use App\Enums\eTypeSalaire;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->float('montant');
            $table->enum('type', eTypeSalaire::getAll(eTypeSalaire::class))->nullable();
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
        Schema::dropIfExists('salaires');
    }
}
