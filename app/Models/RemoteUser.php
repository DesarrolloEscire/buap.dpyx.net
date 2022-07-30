<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteUser extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = "users";

    protected $fillable = [
        'username',
        'names',
        'email',
        'password',
    ];

    /**
     * Add the remote user to dpyx user database and their roles
     * 
     */

    public function roles()
    {
        return $this->belongsToMany(
            RemoteRole::class,
            'model_has_roles',
            'model_id',
            'role_id'
        );
    }

    public function user()
    {
        return $this->setConnection('pgsql')->belongsTo(
            User::class,
            'identifier',
            'identifier',
        );
    }

    public function scopeWhereIdentifier($query, string $identifier)
    {
        return $query->where('identifier', $identifier);
    }
}
