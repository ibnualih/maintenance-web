<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SwingCircle extends Model
{
    protected $fillable = [
        'user_id',
        'unit_model',
        'unit_code',
        'hm',
        'last_update',
        'peak_value',
        'front_value',
        'rear_value',
        'front_picture',
        'rear_picture',
        'level_grease_picture',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor untuk perhitungan dinamis
    public function getEdAttribute($value)
    {
        // Hitung dinamis jika last_update tersedia
        if ($this->last_update) {
            $lastUpdate = Carbon::parse($this->last_update);
            $dynamicEd = $lastUpdate->diffInDays(Carbon::now());

            // Return hasil perhitungan dinamis atau yang tersimpan
            return $dynamicEd > $value ? $dynamicEd : $value;
        }

        return $value;
    }

    protected $casts = [
        'last_update' => 'datetime',
    ];

    public function getLastUpdateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y'); // Format tanggal default
    }

    public function setLastUpdateAttribute($value)
    {
        $this->attributes['last_update'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
