<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    const DC_IDENTIFIER_ORCID = "dc.identifier.orcid";
    const DC_CONTRIBUTOR_DEPARTMENT = "dc.contributor.department";

    const DROPDOWN_TYPE = "dropdown";
    const QUALDROP_VALUE_TYPE = "qualdrop_value";

    const RECORDS_PER_PAGE = 6;

    protected $fillable = [
        'hint',
        'input_type',
        'is_required',
        'is_repeatable',
        'label',
        'name',
        'placeholder',
        'position',
        'value_pair_group',
    ];

    public $timestamps = false;

    public function metadataValues()
    {
        return $this->hasMany(
            MetadataValue::class,
            'metadata_id',
            'id'
        );
    }

    public function getIsDropdownAttribute()
    {
        return $this->input_type == self::DROPDOWN_TYPE;
    }

    public function getIsQualdropValueAttribute()
    {
        return $this->input_type == self::QUALDROP_VALUE_TYPE;
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_required', false);
    }

    public function scopePage($query, int $page)
    {
        return $query
            ->offset(($page - 1) * self::RECORDS_PER_PAGE)
            ->limit(self::RECORDS_PER_PAGE);
    }
}
