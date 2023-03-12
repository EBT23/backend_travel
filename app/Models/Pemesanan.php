<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan'; //nama tabel pada database

    protected $fillable = [ //kolom yang diizinkan diisi secara massal
        'id_persediaan_tiket',
        'nama_pemesan',
        'email',
        'no_hp',
        'alamat',
        'nama_penumpang'
    ];
}
