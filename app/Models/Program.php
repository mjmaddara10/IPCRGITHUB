<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
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
        'budget',
        'division_id',
        'order',
        'gass_id'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function activityRequests()
    {
        return $this->hasMany(ActivityRequest::class);
    }

    public function divisions() {
        return $this->belongsToMany(Division::class);
    }

    public function gass()
    {
        return $this->belongsTo(Gass::class, 'gass_id');
    }

    
}
