<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'mitra_id',
        'survey_id',
        'target',
        'payment',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function nilai1()
    {
        return $this->hasOne(Nilai1::class, 'transaction_id', 'id');
    }
    public function nilai2()
    {
        return $this->hasOne(Nilai1::class, 'transaction_id', 'id');
    }
}
