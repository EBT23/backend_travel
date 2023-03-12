<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan_tiket extends Model
{
    use HasFactory;

    protected $table = 'persediaan_tiket'; //nama tabel pada database

    protected $fillable = [ //kolom yang diizinkan diisi secara massal
        'tgl_keberangkatan',
        'asal',
        'tujuan',
        'kuota',
        'estimasi_perjalanan',
        'harga'
    ];
}
