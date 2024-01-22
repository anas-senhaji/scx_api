<?php

use App\Enums\eTypeAbsence;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_absences', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('couleur')->nullable();
            $table->enum('type', eTypeAbsence::getAll(eTypeAbsence::class));
            $table->string('nom');
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
        Schema::dropIfExists('type_absences');
    }
}
