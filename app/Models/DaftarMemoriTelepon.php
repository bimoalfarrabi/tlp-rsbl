<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarMemoriTelepon extends Model
{
    use HasFactory;

    protected $table = 'daftar_memori_telepon';

    protected $fillable = [
        'memori',
        'nama',
    ];
}
