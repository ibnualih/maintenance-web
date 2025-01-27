<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisaPAP extends Model
{
    use HasFactory;

    protected $table = 'analisa_paps';

    protected $fillable = [
        'grouploc', 'ADD_CODE', 'branch', 'Lab_No', 'SAMPL_DT1', 'unit_id', 'customer_id',
        'name', 'ComponentID', 'MODEL', 'OIL_TYPE', 'HRS_KM_TOT', 'oil_change', 'visc_40', 
        'TBN_CODE', 'CALCIUM', 'ZINC_CODE', 'WATER', 'SODIUM', 'SILICON', 'IRON', 
        'FE_CODE', 'LEAD', 'RECOMM1', 'Notes'
    ];

    // Mutator untuk memastikan huruf kapital pada atribut tertentu
    public function setGrouplocAttribute($value)
    {
        $this->attributes['grouploc'] = strtoupper($value);
    }

    public function setAddCodeAttribute($value)
    {
        $this->attributes['ADD_CODE'] = strtoupper($value);
    }

    public function setBranchAttribute($value)
    {
        $this->attributes['branch'] = strtoupper($value);
    }

    public function setLabNoAttribute($value)
    {
        $this->attributes['Lab_No'] = strtoupper($value);
    }

    public function setSamplDt1Attribute($value)
    {
        $this->attributes['SAMPL_DT1'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setUnitIdAttribute($value)
    {
        $this->attributes['unit_id'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setCustomerIdAttribute($value)
    {
        $this->attributes['customer_id'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setComponentIdAttribute($value)
    {
        $this->attributes['ComponentID'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setModelAttribute($value)
    {
        $this->attributes['MODEL'] = strtoupper($value);
    }

    public function setOilTypeAttribute($value)
    {
        $this->attributes['OIL_TYPE'] = strtoupper($value);
    }

    public function setHrsKmTotAttribute($value)
    {
        $this->attributes['HRS_KM_TOT'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setOilChangeAttribute($value)
    {
        $this->attributes['oil_change'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setVisc40Attribute($value)
    {
        $this->attributes['visc_40'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setTbnCodeAttribute($value)
    {
        $this->attributes['TBN_CODE'] = strtoupper($value);
    }

    public function setCalciumAttribute($value)
    {
        $this->attributes['CALCIUM'] = strtoupper($value);
    }

    public function setZincCodeAttribute($value)
    {
        $this->attributes['ZINC_CODE'] = strtoupper($value);
    }

    public function setWaterAttribute($value)
    {
        $this->attributes['WATER'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setSodiumAttribute($value)
    {
        $this->attributes['SODIUM'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setSiliconAttribute($value)
    {
        $this->attributes['SILICON'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setIronAttribute($value)
    {
        $this->attributes['IRON'] = $value; // Tidak diubah, simpan seperti adanya
    }

    public function setFeCodeAttribute($value)
    {
        $this->attributes['FE_CODE'] = strtoupper($value);
    }

    public function setLeadAttribute($value)
    {
        $this->attributes['LEAD'] = strtoupper($value);
    }

    public function setRecomm1Attribute($value)
    {
        $this->attributes['RECOMM1'] = strtoupper($value);
    }

    public function setNotesAttribute($value)
    {
        $this->attributes['Notes'] = $value; // Tidak diubah, simpan seperti adanya
    }
}
