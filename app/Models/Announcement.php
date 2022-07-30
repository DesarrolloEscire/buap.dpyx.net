<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        "initial_date",
        "final_date",
        "motive",
    ];

    /**
     * ===========
     * SCOPE METHODS
     * ===========
     */

    public function scopeActive($query)
    {
        return $query->whereDate('initial_date', '<=', Carbon::now())
            ->whereDate('final_date', '>=', Carbon::now());
    }

    /**
     * =========
     * ATTTRIBUTES
     * =========
     */

    public function getStatusAttribute()
    {
        if ($this->initial_date > date('Y-m-d')) return 'pendiente';
        if ($this->final_date < date('Y-m-d')) return 'finalizado';
        return 'en progreso';
    }

    public function getStatusColorAttribute(){
        if($this->is_pending) return 'warning';
        if($this->is_finalized) return 'dark';
        if($this->is_in_progress) return 'success';
    }

    /**
     * ========
     * BOOLEANS
     * ========
     */

    public function getIsPendingAttribute()
    {
        return $this->status == 'pendiente';
    }

    public function getIsFinalizedAttribute()
    {
        return $this->status == 'finalizado';
    }

    public function getIsInProgressAttribute()
    {
        return $this->status == 'en progreso';
    }
}
