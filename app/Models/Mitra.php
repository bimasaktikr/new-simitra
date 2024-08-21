<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';

    protected $fillable = [
        'user_id',
        'name',
        'pendidikan',
        'jenis_kelamin',
        'umur',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
