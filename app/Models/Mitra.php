<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';
    protected $primaryKey = 'id_sobat';
    public $incrementing = false; 

    protected $fillable = [
        'id_sobat',
        'name',
        'email',
        'pendidikan',
        'jenis_kelamin',
        'tanggal_lahir',
        'photo',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'mitra_id', 'id_sobat');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }

    public function nilai2()
    {
        return $this->hasMany(Nilai2::class, 'mitra_id', 'id_sobat');
    }

    public function surveys()
    {
        return $this->hasManyThrough(
            Survey::class,
            Transaction::class,
            'mitra_id',    // Foreign key on transactions table...
            'id',          // Foreign key on surveys table...
            'id_sobat',    // Local key on mitras table...
            'survey_id'    // Local key on transactions table...
        );
    }

    public function mitraTeladan()
    {
        return $this->hasMany(MitraTeladan::class, 'mitra_id', 'id_sobat');
    }
}
