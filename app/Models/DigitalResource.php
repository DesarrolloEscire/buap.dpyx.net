<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'repository_id'
    ];

    public function repository()
    {
        return $this->belongsTo(
            Repository::class,
            'repository_id',
            'id'
        );
    }

    public function metadataValues()
    {
        return $this->belongsToMany(
            MetadataValue::class,
            'digital_resource__metadata_value',
            'digital_resource_id',
            'metadata_value_id'
        );
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'digital_resource__file',
            'digital_resource_id',
            'file_id'
        );
    }

    public function urls()
    {
        return $this->belongsToMany(
            Url::class,
            'digital_resource__url',
            'digital_resource_id',
            'url_id'
        );
    }
}
