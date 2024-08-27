<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';

    protected $fillable = [
        'id_sobat',
        'name',
        'email',
        'pendidikan',
        'jenis_kelamin',
        'tanggal_lahir',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'mitra_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }
}
