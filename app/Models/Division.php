<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function programs() {
        return $this->belongsToMany(Program::class);
    }

    public function programRequests() {
        return $this->belongsToMany(ProgramRequest::class, 'division_program_requests', 'division_id', 'program_requests_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}