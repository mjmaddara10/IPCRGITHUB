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
        'division',
        'status',
        'role',
    ];

    public function employees()
    {
        return $this->belongsTo(Activity::class);
    }

    protected $hidden = [
        'password',
    ];
}
