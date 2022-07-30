<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteRepository extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = "repositories";

    public function repository()
    {
        return $this->setConnection('pgsql')->belongsTo(
            Repository::class,
            'id',
            'id',
        );
    }

    public function remoteEvaluation()
    {
        return $this->setConnection('mysql')->hasOne(
            'App\Models\RemoteEvaluation',
            'id',
            'id'
        );
    }

    public function remoteUser()
    {
        return $this->setConnection('mysql')->belongsTo(
            RemoteUser::class,
            'responsible_id',
        );
    }
}
