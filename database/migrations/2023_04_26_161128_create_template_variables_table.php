<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_variables', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('variable');
            $table->string('equivalent')->nullable();
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates');
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
        Schema::dropIfExists('template_variables');
    }
}
