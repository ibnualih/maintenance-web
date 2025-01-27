<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MagneticPluck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_model',
        'unit_code',
        'hm',
        'last_update',
        'component',
        'rating',
        'picture',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Event sebelum data disimpan
        static::saving(function ($model) {
            if ($model->last_update) {
                $model->ed = Carbon::parse($model->last_update)->diffInDays(Carbon::now());
            }
        });
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
