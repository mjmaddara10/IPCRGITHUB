<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
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
        'activity_id',
        'order',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'sub_activity_employee', 'sub_activity_id', 'employee_id');
    }
}
