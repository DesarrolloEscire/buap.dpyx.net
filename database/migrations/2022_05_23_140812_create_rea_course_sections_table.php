<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rea_course_sections', function (Blueprint $table) {
            $table->id()->autoincrement();
            $table->string('key_section')->unique();
            $table->unsignedBigInteger('order');
            $table->longText('title',200)->nullable();
            $table->longText('description')->nullable();
            $table->longText('icon')->nullable();
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
        Schema::dropIfExists('rea_course_sections');
    }
}
