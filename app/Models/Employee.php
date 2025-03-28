<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $table = 'tbl_employee';

    protected $fillable = [
        'username',
        'password',
        'firstName',
        'middleName',
        'lastName',
        'position',
        'division',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
