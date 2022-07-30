<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repository_id');
            $table->text('path')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('digital_resources');
    }
}
