<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnalisaFuelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:NORMAL,CAUTION,CRITICAL',  // Status harus salah satu dari tiga opsi
            'lab_number' => 'required|string',                         // Lab number wajib, tipe string
            'customer_name' => 'required|string',                      // Nama customer wajib, tipe string
            'branch' => 'required|string',                             // Branch wajib, tipe string
            'sample_date' => 'required|date',                          // Sample date wajib, tipe tanggal
            'report_date' => 'required|date',                          // Report date wajib, tipe tanggal
            'unit' => 'required|string',                               // Unit wajib, tipe string
            'type_unit' => 'required|string',                          // Type unit wajib, tipe string
            'code_unit' => 'required|string',                          // Tambahkan code_unit
            'serial_number' => 'required|string',                      // Serial number wajib, tipe string
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => strtoupper($this->status),
            'lab_number' => strtoupper($this->lab_number),
            'customer_name' => strtoupper($this->customer_name),
            'branch' => strtoupper($this->branch),
            'unit' => strtoupper($this->unit),           // Unit diubah menjadi huruf besar
            'type_unit' => strtoupper($this->type_unit),
            'code_unit' => strtoupper($this->code_unit), // Tambahkan code_unit di sini
            'serial_number' => strtoupper($this->serial_number),
        ]);
    }
}
