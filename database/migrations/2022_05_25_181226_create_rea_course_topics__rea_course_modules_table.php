<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseTopicsReaCourseModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_topics__rea_course_modules', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('rea_course_topics_id');
            $table->unsignedBigInteger('rea_course_modules_id');

            $table->foreign('rea_course_topics_id')->references('id')->on('rea_course_topics')->cascadeOnDelete();
            $table->foreign('rea_course_modules_id')->references('id')->on('rea_course_modules')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rea_course_topics__rea_course_modules');
    }
}
