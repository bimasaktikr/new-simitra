<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraTeladan extends Model
{
    use HasFactory;

    protected $table = 'nilai1';

    protected $fillable = [
        'mitra_id',
        'tim',
        'nilai_tahap1',
        'nilai_tahap2',
        'tahun',
        'periode',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
