<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WheelBrake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_code',
        'hm',
        'ed',
        'last_date',
        'flh_rgauge',
        'flh_tbase',
        'frh_rgauge',
        'frh_tbase',
        'rlh_rgauge',
        'rlh_tbase',
        'rrh_rgauge',
        'rrh_tbase',
        'picture',
        // 'resume_date',
        // 'remark',
        // 'resume_flh_rgauge',
        // 'resume_flh_tbase',
        // 'resume_frh_rgauge',
        // 'resume_frh_tbase',
        // 'resume_rlh_rgauge',
        // 'resume_rlh_tbase',
        // 'resume_rrh_rgauge',
        // 'resume_rrh_tbase',
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
            if ($model->last_date) {
                $model->ed = Carbon::parse($model->last_date)->diffInDays(Carbon::now());
            }
        });
    }

    protected $casts = [
        'last_date' => 'datetime',
    ];

    public function getLastUpdateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y'); // Format tanggal default
    }

    public function setLastUpdateAttribute($value)
    {
        $this->attributes['last_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
