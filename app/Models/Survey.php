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
        'kode',
        'ketua_tim',
        'tanggal_mulai',
        'tanggal_berakhir',
        'tipe_pembayaran',
        'harga',
    ];
}
