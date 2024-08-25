<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'team_id', 'id');
    }

    public function survey()
    {
        return $this->hasMany(Survey::class, 'team_id', 'id');
    }
}
