<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalisaFuelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'required|string',
            'lab_number' => 'required|string',
            'customer_name' => 'required|string',
            'branch' => 'required|string',
            'sample_date' => 'required|date',
            'report_date' => 'required|date',
            'unit' => 'required|string',           // Tetap ada unit
            'type_unit' => 'required|string',
            'code_unit' => 'required|string',      // Tambahkan code_unit
            'serial_number' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => strtoupper($this->status),
            'lab_number' => strtoupper($this->lab_number),
            'customer_name' => strtoupper($this->customer_name),
            'branch' => strtoupper($this->branch),
            'unit' => strtoupper($this->unit),           // Tetap ada unit
            'type_unit' => strtoupper($this->type_unit),
            'code_unit' => strtoupper($this->code_unit), // Tambahkan code_unit
            'serial_number' => strtoupper($this->serial_number),
        ]);
    }
}
