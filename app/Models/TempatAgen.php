<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatAgen extends Model
{
    use HasFactory;
    protected $table = 'tempat_agen';
    protected $fillable = [
        'id',
        'kota_id',
        'tempat_agen',
        'created_at',
        'updated_at',
    ];
}
