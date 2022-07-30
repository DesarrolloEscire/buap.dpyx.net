<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptRepositoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept__repository', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('concept_id');
            $table->unsignedBigInteger('repository_id');

            $table
                ->foreign('concept_id')
                ->references('id')
                ->on('concepts')
                ->onDelete('CASCADE');

            $table
                ->foreign('repository_id')
                ->references('id')
                ->on('repositories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concept__repository');
    }
}
