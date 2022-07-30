<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileEvidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_evidences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rea_course_task_activity_id');
            $table->string('path');
            $table->timestamps();

            $table->foreign('rea_course_task_activity_id')
                ->references('id')
                ->on('rea_course_task_activities')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_evidences');
    }
}
