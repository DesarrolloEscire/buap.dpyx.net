<?php

namespace App\Src\Repositories\Application;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class RepositoryCreator
{
    function __construct()
    {
    }

    public function create(string $name, User $responsible, User $evaluator)
    {
        $repository = $responsible->repositories()->create([
            'name' => $name,
            'responsible_id' => $responsible->id
        ]);

        $evaluation = $repository->evaluation()->create([
            'evaluator_id' => $evaluator->id
        ]);

        Question::get()->each(function ($question) use ($evaluation) {
            Answer::create([
                'evaluation_id' => $evaluation->id,
                'question_id' => $question->id,
                'is_updateable' => 1,
            ]);
        });
    }
}
