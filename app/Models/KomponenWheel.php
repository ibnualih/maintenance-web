<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenWheel extends Model
{
    use HasFactory;

    protected $table = 'komponen_wheels'; // Nama tabel

    // Kolom yang dapat diisi
    protected $fillable = [
        'model',
        'code',
        'total_phenomena',
        'status',
    ];
}
