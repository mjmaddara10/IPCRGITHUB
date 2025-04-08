<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
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
        'accountable',
        'program_id',
        'project_id',
        'sub_project_id'
    ];
    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function subProjects()
    {
        return $this->belongsTo(SubProject::class);
    }

    public function subActivities()
    {
        return $this->hasMany(SubActivity::class);
    }
}
