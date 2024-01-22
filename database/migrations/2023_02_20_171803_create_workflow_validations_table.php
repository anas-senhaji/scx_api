<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_validations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('type');
            $table->bigInteger('role_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->boolean('est_superviseur')->default(false);
            $table->integer('niveau');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('workflow_validations');
    }
}
