<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vhms extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'sn',
        'hm',
        'ed',
        'blowby_max',
        'boost_press_max',
        'exh_temp_lf_max',
        'exh_temp_lr_max',
        'exh_temp_rf_max',
        'exh_temp_rr_max',
        'eng_oil_press_hmin',
        'eng_oil_press_lmin',
        'coolant_temp_max',
        'eng_oil_temp_max',
        'tm_oil_temp_max',
    ];
}
