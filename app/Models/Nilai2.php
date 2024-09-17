<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai2 extends Model
{
    use HasFactory;

    protected $table = 'nilai2';

    protected $fillable = [
        'transaction_id',
        'mitra_id',
        'team_id',
        'penilai_id',
        'aspek1',
        'aspek2',
        'aspek3',
        'aspek4',
        'aspek5',
        'aspek6',
        'aspek7',
        'aspek8',
        'aspek9',
        'aspek10',
        'rerata',
        'tahun',
        'periode',
        'is_sudah_dinilai'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function penilai()
    {
        return $this->belongsTo(Employee::class, 'penilai_id');
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
