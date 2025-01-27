<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'handphone',
        'address',
    ];

    public function magneticPlugs()
    {
        return $this->hasMany(MagneticPluck::class);
    }

    public function cuttingFilters()
    {
        return $this->hasMany(CuttingFilter::class);
    }

    public function strainers()
    {
        return $this->hasMany(Strainer::class);
    }

    public function swingCircles()
    {
        return $this->hasMany(SwingCircle::class);
    }

    public function wheelBrakes()
    {
        return $this->hasMany(WheelBrake::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
