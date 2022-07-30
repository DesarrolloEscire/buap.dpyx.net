<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmbedPdfPathColumnToReaCourseTaskActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rea_course_task_activities', function (Blueprint $table) {
            $table->longText('embed_pdf_path')->nullable()->after('instruction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rea_course_task_activities', function (Blueprint $table) {
            $table->dropColumn('embed_pdf_path');
        });
    }
}
