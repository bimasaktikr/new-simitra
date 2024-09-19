<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'nip',
        'jenis_kelamin',
        'email',
        'tanggal_lahir',
        'team_id',
        'peran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function nilai2()
    {
        return $this->hasMany(Nilai2::class, 'penilai_id', 'nip');
    }
}
