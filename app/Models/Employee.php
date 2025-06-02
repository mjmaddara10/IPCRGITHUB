<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $table = 'tbl_employee';

    protected $fillable = [
        'id',
        'username',
        'password',
        'firstName',
        'middleName',
        'lastName',
        'position',
        'division_id',
        'status',
        'role',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_employee', 'employee_id', 'activity_id')
            ->withPivot('signatory_id');
    }

    public function subActivities()
    {
        return $this->belongsToMany(SubActivity::class, 'sub_activity_employee', 'employee_id', 'sub_activity_id')
            ->withPivot('signatory_id');
    }

    public function activityRequests() {
        return $this->belongsToMany(ActivityRequest::class, 'activity_requests_employee', 'employee_id', 'activity_requests_id');
    }

    public function subActivityRequests() {
        return $this->belongsToMany(SubActivityRequest::class, 'sub_activity_requests_employee', 'employee_id', 'sub_activity_requests_id');
    }

    protected $hidden = [
        'password',
    ];
}