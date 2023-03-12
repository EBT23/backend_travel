<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shuttle extends Model
{
    use HasFactory;
    protected $table = 'shuttle'; //nama tabel pada database

    protected $fillable = [ //kolom yang diizinkan diisi secara massal
        'id_jenis_mobil',
        'id_fasilitas',
    ];
}
