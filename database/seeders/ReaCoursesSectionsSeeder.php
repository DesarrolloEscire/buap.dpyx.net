<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReaCourseSection;
class ReaCoursesSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rea_sections_data = [
            (object)["key_section"=>"seccion_principal","order"=>1,"title"=>null,"description"=>null],
            (object)["key_section"=>"seccion_acercade","order"=>2,"title"=>null,"description"=>null],
            (object)["key_section"=>"seccion_requisitos","order"=>3,"title"=>null,"description"=>null],
            (object)["key_section"=>"seccion_asesores","order"=>4,"title"=>null,"description"=>null]
        ];

        foreach($rea_sections_data as $rea_section_data){
            ReaCourseSection::updateOrCreate(
                ['key_section' => $rea_section_data->key_section],
                [
                    "order" => $rea_section_data->order,
                    "title" => $rea_section_data->title,
                    "description" => $rea_section_data->description
                ]
            );
        }
    }
}
