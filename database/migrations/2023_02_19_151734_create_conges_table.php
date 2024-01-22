<?php

use App\Enums\eStatutConge;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->datetime('date_debut');
            $table->datetime('date_fin');
            $table->float('nombre_jours');
            $table->string('justification')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('type_conge_id')->nullable();
            $table->foreign('type_conge_id')->references('id')->on('type_conges')->onDelete('set null');
            $table->unsignedBigInteger('collaborateur_id')->nullable();
            $table->foreign('collaborateur_id')->references('id')->on('collaborateurs')->onDelete('set null');
            $table->enum('statut', eStatutConge::getAll(eStatutConge::class))->default(eStatutConge::_EN_ATTENTE);
            $table->json('workflow');
            $table->integer('niveau_valide')->default(0);
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
        Schema::dropIfExists('conges');
    }
}
