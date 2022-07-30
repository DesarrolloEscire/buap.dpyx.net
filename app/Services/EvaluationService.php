<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\User;

class EvaluationService
{
    public $evaluation;

    public function __invoke(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    public function updateCurrentEvaluator($user)
    {
        $this->evaluation->update(['evaluator_id' => $user->id]);
        return $this;
    }

    public function addNewEvaluatorIfNotExist($user)
    {
        if ($user == null) {
            return $this;
        }

        if (!$this->evaluation->evaluators()->find($user)) {
            $this->evaluation->evaluators()->attach($user);
        }
        return $this;
    }

    // ================
    // 
    // ================

    public function isEvaluatorOfThisEvaluation($user)
    {
        if ($user == null) {
            return false;
        }

        if (!$this->evaluation->evaluators()->find($user)) {
            return false;
        }

        return true;
    }

    public function hasEvaluators()
    {
        return $this->evaluation->evaluators->count() > 0;
    }
}
