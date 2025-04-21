<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedActivity extends Model
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
        'accountable_id',
        'program_id',
    ];

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'activity_employee', 'activity_id', 'employee_id');
    }

    public function selectedSubActivities()
    {
        return $this->hasMany(SelectedSubActivity::class);
    }
}
