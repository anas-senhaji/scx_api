<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaborateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborateurs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('photo')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse_personnelle')->nullable();
            $table->string('email');
            $table->string('telephone');
            $table->string('identification_nationale');
            $table->string('numero_securite_sociale')->nullable();
            $table->string('rib')->nullable();
            $table->date('date_naissance');
            $table->string('situation');
            $table->integer('nombre_enfants')->default(0);
            $table->string('nationalite');
            $table->string('niveau_etudes')->nullable();
            $table->json('diplomes')->nullable();
            $table->json('experiences_antierieurs')->nullable();
            $table->json('langues')->nullable();
            $table->json('competences')->nullable();
            $table->json('avantages')->nullable();
            $table->boolean('statut')->default(true);
            $table->string('fonction')->nullable();
            $table->string('nombre_jours_conge')->nullable();
            $table->float('salaire_de_base');
            $table->string('matricule')->nullable();
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('groupe_id')->nullable();
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('set null');
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('set null');
            $table->unsignedBigInteger('superviseur_id')->nullable();
            $table->foreign('superviseur_id')->references('id')->on('collaborateurs')->onDelete('set null');
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
        Schema::dropIfExists('collaborateurs');
    }
}
