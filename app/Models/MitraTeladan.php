<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraTeladan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'team_id',
        'year',
        'quarter',
        'avg_rating_1',
        'avg_rating_2',
        'status_phase_2',
        'surveys_count',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id', 'id_sobat');
<<<<<<< HEAD
=======
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function nilai2()
    {
        return $this->hasMany(Nilai2::class, 'mitra_teladan_id', 'id');
>>>>>>> dev
    }
}
