<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'payment_types';

    protected $fillable = [
        'payment_type',
    ];

    /**
     * Relationship with Survey
     * One payment type can be associated with multiple surveys
     */
    public function surveys()
    {
        return $this->hasMany(Survey::class, 'payment_type_id', 'id');
    }
}
