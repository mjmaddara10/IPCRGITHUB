<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'successIndicator',
        'quality',
        'efficiency',
        'timeliness',
        'remarks',
        'program_id',
    ];

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function subProjects()
    {
        return $this->hasMany(SubProject::class);
    }
}
