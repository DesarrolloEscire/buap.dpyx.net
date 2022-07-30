<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationColumnToReaCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rea_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('duration')->default(21);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rea_courses', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
}
