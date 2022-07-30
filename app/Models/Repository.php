<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repository extends Model
{
    use HasFactory;

    protected $table = "repositories";
    protected $fillable = [
        "id",
        "responsible_id",
        "is_published",
        "name",
        "status",
    ];

    /**
     * ==========
     * RELATIONSHIPS
     * ==========
     */

    public function concepts()
    {
        return $this->belongsToMany(
            Concept::class,
            'concept__repository',
            'repository_id',
            'concept_id',
        );
    }

    public function digitalResources()
    {
        return $this->hasMany(
            DigitalResource::class,
            'repository_id',
            'id'
        );
    }

    public function evaluation()
    {
        return $this->hasOne('App\Models\Evaluation');
    }

    public function evaluationsHistory()
    {
        return $this->hasMany('App\Models\EvaluationHistory');
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'file__repository',
            'repository_id',
            'file_id'
        )->withPivot('type');
    }

    public function metadataValues()
    {
        return $this->belongsToMany(
            MetadataValue::class,
            'metadata_value__repository',
            'repository_id',
            'metadata_value_id'
        );
    }

    public function responsible()
    {
        return $this->belongsTo('App\Models\User', 'responsible_id');
    }

    /**
     * ========
     * ATTRIBUTES
     * ========
     */

    public function getStatusColorAttribute()
    {
        if ($this->is_in_progress) return 'info';
        if ($this->is_aproved) return 'success';
        if ($this->is_rejected) return 'danger';
        if ($this->has_observations) return 'warning';
    }

    public function getQualificationAttribute()
    {
        // if (!$this->evaluation->answers->count()) return 0;
        if ($this->evaluation->answers->pluck('choice.question.max_punctuation')->flatten()->sum() == 0) return 0;

        return round($this->evaluation->answers->pluck('choice.punctuation')->flatten()->sum() / $this->evaluation->answers->pluck('question.max_punctuation')->flatten()->sum() * 100, 2);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUnpublish($query)
    {
        $query->update(['is_published' => false]);
    }

    /**
     * =======
     * BOOLEANS
     * =======
     */

    public function getIsInProgressAttribute()
    {
        return $this->status == 'en progreso' || $this->evaluation->in_review == 'en revisión';
    }

    public function getHasObservationsAttribute()
    {
        return $this->status == 'observaciones';
    }

    public function getIsAprovedAttribute()
    {
        return $this->status == 'aprobado';
    }

    public function getIsRejectedAttribute()
    {
        return $this->status == 'rechazado';
    }

    public function publish()
    {
        $this->update(['is_published' => true]);
    }
}
