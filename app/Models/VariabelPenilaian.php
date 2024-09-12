<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariabelPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'variabel',
        'tahap',
    ];
}
