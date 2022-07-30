<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAnswerBColumnAsNullableToReaCourseTaskActivityQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rea_course_task_activity_questions', function (Blueprint $table) {
            $table->longText('answer_b')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rea_course_task_activity_questions', function (Blueprint $table) {
            $table->longText('answer_b')->nullable()->change();
        });
    }
}
