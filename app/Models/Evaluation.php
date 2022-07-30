<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'repository_id',
        'evaluator_id',
        'status',
    ];

    /**
     * ==============
     *  RELATIONSHIPS
     * ==============
     */

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function repository()
    {
        return $this->belongsTo('App\Models\Repository');
    }

    public function evaluator()
    {
        return $this->belongsTo('App\Models\User', 'evaluator_id', 'id');
    }
    /*
    public function evaluators()
    {
        return $this->belongsToMany('App\Models\User', 'evaluation_evaluator', 'evaluation_id', 'user_id');
    }*/

    /**
     * ========
     * ATTRIBUTES
     * ========
     */

    public function getStatusColorAttribute()
    {
        if ($this->is_in_progress) return 'info';
        if ($this->in_review) return 'warning';
        if ($this->is_reviewed) return 'success';
        if ($this->is_answered) return 'dark';
        return '';
    }

    /**
     * ========
     * BOOLEANS
     * ========
     */

    public function getIsInProgressAttribute()
    {
        return $this->status == 'en progreso';
    }

    public function getIsReviewedAttribute()
    {
        return $this->status == 'revisado';
    }

    public function getInReviewAttribute()
    {
        return $this->status == 'en revisión';
    }

    public function getIsAnsweredAttribute()
    {
        return $this->status == 'contestada';
    }

    public function getIsViewableAttribute()
    {
        if (!$this->repository->is_published) {
            return false;
        }
        if (Auth::user()->is_admin) {
            return true;
        }
        if (Auth::user()->is_evaluator && $this->is_in_progress) {
            return false;
        }
        if (Auth::user()->is_evaluator && $this->is_answered) {
            return false;
        }
        return true;
    }

    public function getIsAnswerableAttribute()
    {
        if (Auth::user()->id != $this->repository->responsible->id) {
            return false;
        }
        if (!$this->is_in_progress && !$this->is_answered) {
            // dd('2 no');
            return false;
        }
        if (!$this->repository->is_in_progress && !$this->repository->has_observations) {
            // dd('3 no');
            return false;
        }

        return true;
    }

    public function getIsReviewableAttribute()
    {
        if (!config('app.is_evaluable')) {
            return false;
        }


        if (Auth::user()->id != $this->evaluator->id) {
            return false;
        }
        /*
        if(!$this->evaluators()->find(Auth::user()->id)){
            return false;
        }
*/
        if (!$this->in_review) {
            return false;
        }


        return true;
    }
}
