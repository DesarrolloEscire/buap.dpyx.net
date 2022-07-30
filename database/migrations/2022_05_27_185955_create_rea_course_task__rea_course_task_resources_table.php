<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseTaskReaCourseTaskResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_task__rea_course_task_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rea_course_tasks_id');
            $table->unsignedInteger('rea_course_task_resources_id');

            $table->foreign('rea_course_tasks_id')->references('id')->on('rea_course_tasks')->cascadeOnDelete();
            $table->foreign('rea_course_task_resources_id')->references('id')->on('rea_course_task_resources')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rea_course_task__rea_course_task_resources');
    }
}
