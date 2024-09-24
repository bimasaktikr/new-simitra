<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai2 extends Model
{
    use HasFactory;

    protected $table = 'nilai2';

    protected $fillable = [
        'mitra_teladan_id',
        'employee_id',
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
        'is_final',
        
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function mitraTeladan()
    {
        return $this->belongsTo(MitraTeladan::class, 'mitra_teladan_id', 'id');
    }
}
