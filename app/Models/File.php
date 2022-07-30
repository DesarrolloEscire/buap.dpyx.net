<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        "path"
    ];

    public function getNameAttribute()
    {
        $path = explode("/", $this->path);
        return end($path);
    }

    public function getFullPathAttribute()
    {
        return storage_path($this->path);
    }
}
