<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCoursesReaCourseTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_courses__rea_course_topics', function (Blueprint $table) {
            $table->id()->autoincrement();
            $table->unsignedBigInteger('rea_courses_id');
            $table->unsignedBigInteger('rea_course_topics_id');

            $table->foreign('rea_courses_id')->references('id')->on('rea_courses')->cascadeOnDelete();
            $table->foreign('rea_course_topics_id')->references('id')->on('rea_course_topics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rea_courses__rea_course_topics');
    }
}
