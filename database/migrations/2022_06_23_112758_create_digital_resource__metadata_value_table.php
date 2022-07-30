<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalResourceMetadataValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_resource__metadata_value', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('digital_resource_id');
            $table->unsignedBigInteger('metadata_value_id');

            $table
                ->foreign('digital_resource_id')
                ->references('id')
                ->on('digital_resources')
                ->onDelete('cascade');

            $table
                ->foreign('metadata_value_id')
                ->references('id')
                ->on('metadata_values')
                ->references('id')
                ->onDelete('cascade');

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
        Schema::dropIfExists('digital_resource__metadata_value');
    }
}
