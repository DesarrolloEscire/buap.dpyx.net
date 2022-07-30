<?php

namespace Database\Seeders;

use App\Models\Evaluator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EvaluatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating/updating Evaluator level - Highschool
        $educational_level = "media_superior";
        $identifiers_list_1 = ["100023522","100392477","100399022","100518765","100532207","100396044","100065833","100526784","100535650","100266277"];
        
        foreach($identifiers_list_1 as $identifier){
            $user = User::Where('identifier',$identifier)->first();
            if($user){
                Evaluator::updateOrCreate([
                    "evaluator_id" => $user->id
                ],[
                    "evaluator_id" => $user->id,
                    "identifier" => $user->identifier,
                    "educational_level" => $educational_level,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
            }
        }

        // Creating/updating Evaluator level - University
        $educational_level = "des";
        $identifiers_list_2 = ["100502188","100532101","100000112","100532305","NSS0000XX","100503111"];

        foreach($identifiers_list_2 as $identifier){
            $user = User::Where('identifier',$identifier)->first();
            if($user){
                Evaluator::updateOrCreate([
                    "evaluator_id" => $user->id
                ],[
                    "evaluator_id" => $user->id,
                    "identifier" => $user->identifier,
                    "educational_level" => $educational_level,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
            }
        }
    }
}
