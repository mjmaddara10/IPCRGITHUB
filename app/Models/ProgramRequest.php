<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRequest extends Model
{
    protected $table = 'program_requests';

    protected $fillable = [
        'program_id',
        'requested_by',
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

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function divisions() {
        return $this->belongsToMany(Division::class, 'division_program_requests', 'program_requests_id', 'division_id');
    }
}
