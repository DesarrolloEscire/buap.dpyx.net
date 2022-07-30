<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReaCourse;

class ReaCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReaCourse::updateOrCreate(
            ["course_name"=>"rea"],
            ["course_name"=>"rea"]
        );
    }
}
