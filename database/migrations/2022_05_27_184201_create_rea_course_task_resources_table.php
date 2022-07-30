<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseTaskResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_task_resources', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('order');
            $table->unsignedBigInteger('resource_category');
            $table->longText('resource_type',50);
            $table->longText('resource_description')->nullable();
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
        Schema::dropIfExists('rea_course_task_resources');
    }
}
