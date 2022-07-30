<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseTaskActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_task_activities', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('order');
            $table->longText('title',200);
            $table->longText('instruction')->nullable();
            $table->unsignedBigInteger('type')->comment('1: Contenido, 2: Cuestionario')->nullable();
            $table->boolean('needs_evidence')->nullable();
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
        Schema::dropIfExists('rea_course_task_activities');
    }
}
