<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'tbl_admin';

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
