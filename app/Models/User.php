<?php

declare(strict_types=1);

namespace App\Models;

use App\Src\Users\Application\SyncAcademicUnits;
use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use MustVerifyEmail;

    protected $fillable = [
        'identifier',
        'name',
        'email',
        'password',
        'remember_token',
        'phone',
        'profile_photo_path',
        'email_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    |
    */


    public function evaluator(){
        return $this->hasOne(Evaluator::class,"evaluator_id","id");
    }

    public function academicUnits()
    {
        return $this->belongsToMany(
            AcademicUnit::class,
            'academic_unit__user',
            'user_id',
            'academic_unit_id'
        );
    }

    public function courses()
    {
        return $this->hasMany(
            Course::class,
            'user_id',
            'id'
        );
    }

    public function evaluations()
    {
        return $this->belongsToMany('App\Models\Evaluation', 'evaluation_evaluator');
    }

    public function quizzes()
    {
        return $this->hasMany(
            Quizz::class,
            'user_id'
        );
    }

    public function repositories()
    {
        return $this->hasMany('App\Models\Repository', 'responsible_id');
    }

    public function reaCourseResponses()
    {
        return $this->hasMany(
            Response::class,
            'user_id',
            'id'
        );
    }
    public function reaCourseEvidences()
    {
        return $this->hasMany(
            FileEvidence::class,
            'user_id',
            'id'
        );
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'responsible__subject',
            'user_id',
            'subject_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scope methods
    |--------------------------------------------------------------------------
    |
    */

    public function scopeEvaluators($query)
    {
        return $query->whereHas('roles', function ($query) {
            return $query->where('name', 'evaluador');
        });
    }

    public function scopeUsers($query)
    {
        return $query->whereHas('roles', function ($query) {
            return $query->where('name', Role::TEACHER_ROLE);
        });
    }

    public function scopeWhereIdentifier($query, string $identifier)
    {
        return $query->where('identifier', $identifier);
    }

    public function scopeWhereNotIdentifier($query, string $identifier)
    {
        return $query->where('identifier', '!=', $identifier)->orWhereNull('identifier');
    }

    public function scopeWhereNotUser($query, User $user)
    {
        return $query->where('users.id', '!=', $user->id);
    }

    public function scopeWhereRole($query, Role $role)
    {
        return $query->whereHas('roles', function ($query) use ($role) {
            return $query->where('roles.id', $role->id);
        });
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    public function getRoleColorAttribute()
    {
        if ($this->is_evaluator) return 'warning';
        if ($this->is_admin) return 'danger';
        if ($this->is_teacher) return 'info';
        return '';
    }

    public function getIsTeacherAttribute()
    {
        return $this->hasRole(Role::TEACHER_ROLE);
    }

    /*
    |--------------------------------------------------------------------------
    | Calculated attributes
    |--------------------------------------------------------------------------
    |
    */

    public function getHasRepositoriesAttribute()
    {
        return $this->repositories->count() > 0;
    }

    public function getIsEvaluatorAttribute()
    {
        return $this->hasRole('evaluador');
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole(Role::ADMINISTRATOR_ROLE);
    }

    public function getIsActiveAttribute()
    {
        if (!$this->last_login_at) return false;

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:i:s'));
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $this->last_login_at);
        $diffInMonths = $to->diffInMonths($from);
        if ($diffInMonths >= 1) return false;

        return true;
    }

    public function getIsVerifiedAttribute()
    {
        return $this->email_verified_at != null;
    }

    /*
    |--------------------------------------------------------------------------
    | Extra methods
    |--------------------------------------------------------------------------
    |
    */

    public function verify()
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
    }

    public function unverify()
    {
        $this->email_verified_at = null;
        $this->save();
    }

    public function syncAcademicUnits($academicUnits)
    {
        (new SyncAcademicUnits)
            ->handle($this, $academicUnits);
    }
}
