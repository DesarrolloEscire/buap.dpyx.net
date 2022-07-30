<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetadataValue extends Model
{
    use HasFactory;

    protected $table = "metadata_values";

    protected $fillable = [
        "metadata_id",
        "value"
    ];

    public $timestamps = false;

    public function metadata()
    {
        return $this->belongsTo(
            'App\Models\Metadata',
            'metadata_id',
            'id'
        );
    }

    public function repositories()
    {
        return $this->belongsToMany(
            Repository::class,
            'metadata_value__repository',
            'metadata_value_id',
            'repository_id'
        );
    }

    public function digitalResources()
    {
        return $this->belongsToMany(
            DigitalResource::class,
            'digital_resource__metadata_value',
            'metadata_value_id',
            'digital_resource_id'
        );
    }

    public function scopeWhereMetadata($query, Metadata $metadata)
    {
        return $query->where('metadata_id', $metadata->id);
    }

    public function scopeWhereMetadataRequired($query)
    {
        return $query->whereHas('metadata', function ($query) {
            return $query->required();
        });
    }

    public function scopeWhereRepository($query, Repository $repository)
    {
        return $query->whereHas('repositories', function ($query) use ($repository) {
            return $query->where('repositories.id', $repository->id);
        });
    }

    public function scopeWhereDigitalResource($query, DigitalResource $digitalResource)
    {
        return $query->whereHas('digitalResources', function ($query) use ($digitalResource) {
            return $query->where('digital_resources.id', $digitalResource->id);
        });
    }
}
