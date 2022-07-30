<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ReaCourse;
use App\Models\ReaCourseSection;

class ReaCourses_ReaCourseSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rea_course = ReaCourse::Where('course_name','rea')->first();
        $rea_course_sections = ReaCourseSection::orderBy('order','ASC')->get();

        $rea_course__rea_course_section = [];

        foreach($rea_course_sections as $rea_course_section){
            $rea_course__rea_course_section[] = ["rea_courses_id"=>$rea_course->id,"rea_course_sections_id"=>$rea_course_section->id];
        }

        DB::table("rea_courses__rea_course_sections")->insert($rea_course__rea_course_section);
    }
}
