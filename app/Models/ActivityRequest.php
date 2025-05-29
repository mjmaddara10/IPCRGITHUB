<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityRequest extends Model
{
    protected $table = 'activity_requests';

    protected $fillable = [
        'activity_id',
        'program_id',
        'requestor',
        'name',
        'successIndicator',
        'quality',
        'efficiency',
        'timeliness',
        'remarks',
        'budget',
        'status',
        'action'
    ];

    public function program() //Parent once approved in adding
    {
        return $this->belongsTo(Program::class);
    }

    public function activity() //Reference for editing
    {
        return $this->belongsTo(Activity::class);
    }

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requestor');
    }

    public function employees() {
        return $this->belongsToMany(Employee::class, 'activity_requests_employee', 'activity_requests_id', 'employee_id');
    }
}
