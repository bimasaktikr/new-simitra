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
        'avg_rating',
        'surveys_count',
    ];

    public function mitra()
    {
        return $this->belongsTo(MitraTeladan::class, 'mitra_id', 'id_sobat');
    }
}
