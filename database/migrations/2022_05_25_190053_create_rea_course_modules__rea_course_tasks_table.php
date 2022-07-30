<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseModulesReaCourseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_modules__rea_course_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('rea_course_modules_id');
            $table->unsignedBigInteger('rea_course_tasks_id');

            $table->foreign('rea_course_modules_id')->references('id')->on('rea_course_modules')->cascadeOnDelete();
            $table->foreign('rea_course_tasks_id')->references('id')->on('rea_course_tasks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rea_course_modules__rea_course_tasks');
    }
}
