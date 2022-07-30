<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('metadata_id');
            $table->unsignedBigInteger('repository_id');
            $table->text('value');

            $table
                ->foreign('metadata_id')
                ->references('id')
                ->on('metadata')
                ->onDelete('CASCADE');
            
            $table
                ->foreign('repository_id')
                ->references('id')
                ->on('repositories')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_values');
    }
}
