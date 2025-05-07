<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_trails';

    protected $fillable = [
        'user_id',
        'full_name',
        'role',
        'action',
        'action_from',
        'action_to',
        'program_name',
    ];

    /**
     * Get the employee (user) who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
