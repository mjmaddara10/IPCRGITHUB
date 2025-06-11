<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GassRequest extends Model
{
    protected $table = 'gass_requests';

    protected $fillable = [
        'budget',
        'gass_id',
        'requestor',
        'status',
        'action',
    ];

    public function gass()
    {
        return $this->belongsTo(Gass::class);
    }

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requestor');
    }
}
