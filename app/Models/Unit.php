<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',     // Tipe Unit
        'unit',     // Unit
        'code_unit',// Code Unit
        'serial_number' // Serial Number
    ];
}
