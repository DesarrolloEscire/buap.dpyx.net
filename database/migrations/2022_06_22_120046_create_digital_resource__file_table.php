<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalResourceFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_resource__file', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('digital_resource_id');
            $table->unsignedBigInteger('file_id');

            $table
                ->foreign('digital_resource_id')
                ->references('id')
                ->on('digital_resources')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');
        });

        Schema::table('digital_resources', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_resource__file');

        Schema::table('digital_resources', function (Blueprint $table) {
            $table->text('path')->nullable();
        });
    }
}
