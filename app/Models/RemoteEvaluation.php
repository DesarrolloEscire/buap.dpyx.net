<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteEvaluation extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = "evaluations";


    public function remoteEvaluator()
    {
        return $this->setConnection('mysql')->belongsTo(
            RemoteUser::class,
            'evaluator_id',
            'id'
        );
    }
    
    public function remoteRepository()
    {
        return $this->setConnection('mysql')->belongsTo(
            RemoteRepository::class,
            'repository_id',
            'id'
        );
    }

    public function evaluation(){
        return $this->belongsTo(
            Evaluation::class,
            'id',
            'id'
        );
    }
}
