<?php

use App\Enums\eTypeContrat;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->enum('type', eTypeContrat::getAll(eTypeContrat::class));
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('remunere')->nullable();
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates');
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
        Schema::dropIfExists('contrats');
    }
}
