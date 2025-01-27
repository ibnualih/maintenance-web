<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisaFuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'lab_number',
        'customer_name',
        'branch',
        'sample_date',
        'report_date',
        'unit',            // Tambahkan unit di sini
        'type_unit',
        'code_unit',      // Tambahkan code_unit di sini
        'serial_number',
    ];

    // Mutator untuk memastikan huruf kapital
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtoupper($value);
    }

    public function setLabNumberAttribute($value)
    {
        $this->attributes['lab_number'] = strtoupper($value);
    }

    public function setCustomerNameAttribute($value)
    {
        $this->attributes['customer_name'] = strtoupper($value);
    }

    public function setBranchAttribute($value)
    {
        $this->attributes['branch'] = strtoupper($value);
    }

    public function setUnitAttribute($value)             // Tambahkan mutator untuk unit
    {
        $this->attributes['unit'] = strtoupper($value);
    }

    public function setTypeUnitAttribute($value)
    {
        $this->attributes['type_unit'] = strtoupper($value);
    }

    public function setCodeUnitAttribute($value)         // Tambahkan mutator untuk code_unit
    {
        $this->attributes['code_unit'] = strtoupper($value);
    }

    public function setSerialNumberAttribute($value)
    {
        $this->attributes['serial_number'] = strtoupper($value);
    }

    // Add other relations and methods as needed
}
