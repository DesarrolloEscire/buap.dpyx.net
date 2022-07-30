<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_tasks', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('order');
            $table->longText('task_name',200);
            $table->longText('title',200);
            $table->longText('goal')->nullable();
            $table->longText('evidence')->nullable();
            $table->tinyInteger('limit_type')->comment("1: por días (número), 2: por fecha específica (datetime)");
            $table->integer('days')->nullable();
            $table->dateTime('deadline_date')->nullable();
            $table->longText('evaluation')->nullable();
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
        Schema::dropIfExists('rea_course_tasks');
    }
}
