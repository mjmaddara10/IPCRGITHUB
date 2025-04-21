<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedSubActivity extends Model
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
        'accountable_id',
        'activity_id',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function activities()
    {
        return $this->belongsTo(Activity::class);
    }
}
