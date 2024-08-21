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
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymnetType::class, 'payment_type_id');
    }
}
