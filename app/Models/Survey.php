<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = [
        'name',
        'code',
        'payment_type_id',
        'start_date',
        'end_date',
        'payment',
        'team_id',
        'file',
        'is_sudah_dinilai',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'survey_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
