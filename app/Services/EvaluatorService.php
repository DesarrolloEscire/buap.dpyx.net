<?php

namespace App\Services;

use App\Models\User;

class EvaluatorService
{
    public $evaluator;

    public function __invoke(User $evaluator)
    {
        $this->evaluator = $evaluator;
        return $this;
    }

    public function getAllEvaluations()
    {
        return $this->evaluator->evaluations;
    }
}
