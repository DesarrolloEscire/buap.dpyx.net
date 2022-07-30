<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseActivitiesReaCourseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_activities__rea_course_questions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('rea_course_task_activities_id');
            $table->foreign('rea_course_task_activities_id')->references('id')->on('rea_course_task_activities')->cascadeOnDelete();
            $table->unsignedBigInteger('rea_course_task_questions_id');
            $table->foreign('rea_course_task_questions_id')->references('id')->on('rea_course_task_activity_questions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rea_course_activities__rea_course_questions');
    }
}
