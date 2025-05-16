<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gass extends Model
{
    use HasFactory;

    protected $table = 'gass';
    
    protected $fillable = [
        'id',
        'name',
        'budget',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
