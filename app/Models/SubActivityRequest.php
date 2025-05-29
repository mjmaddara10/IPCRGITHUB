<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivityRequest extends Model
{
    protected $table = 'sub_activity_requests';

    protected $fillable = [
        'sub_activity_id',
        'activity_id',
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

    public function activity() //Parent once approved in adding
    {
        return $this->belongsTo(Activity::class);
    }

    public function subActivity() //Reference for editing
    {
        return $this->belongsTo(SubActivity::class);
    }

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requestor');
    }

    public function employees() {
        return $this->belongsToMany(Employee::class, 'sub_activity_requests_employee', 'sub_activity_requests_id', 'employee_id');
    }
}
