<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalResourceUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_resource__url', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_resource_id');
            $table->unsignedBigInteger('url_id');

            $table
                ->foreign('digital_resource_id')
                ->references('id')
                ->on('digital_resources')
                ->onDelete('CASCADE');

            $table
                ->foreign('url_id')
                ->references('id')
                ->on('urls')
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
        Schema::dropIfExists('digital_resource__url');
    }
}
