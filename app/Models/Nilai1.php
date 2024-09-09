<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai1 extends Model
{
    use HasFactory;

    protected $table = 'nilai1';

    protected $fillable = [
        'transaction_id',
        'aspek1',
        'aspek2',
        'aspek3',
        'rerata',
    ];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}

