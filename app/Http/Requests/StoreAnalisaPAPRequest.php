<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalisaPAPRequest extends FormRequest
{
    public function rules()
    {
        return [
            'grouploc' => 'nullable|string|max:50',
            'ADD_CODE' => 'nullable|string|max:50',
            'branch' => 'nullable|string|max:50',
            'Lab_No' => 'nullable|string|max:50',
            'SAMPL_DT1' => 'nullable|date',
            'unit_id' => 'nullable|integer',
            'customer_id' => 'nullable|integer',
            'name' => 'nullable|string|max:100',
            'ComponentID' => 'nullable|integer',
            'MODEL' => 'nullable|string|max:50',
            'OIL_TYPE' => 'nullable|string|max:50',
            'HRS_KM_TOT' => 'nullable|integer',
            'oil_change' => 'nullable|boolean',
            'visc_40' => 'nullable|numeric|between:0,9999.99', // Precision float
            'TBN_CODE' => 'nullable|string|max:50',
            'CALCIUM' => 'nullable|numeric|between:0,9999.99',
            'ZINC_CODE' => 'nullable|string|max:50',
            'WATER' => 'nullable|string|max:50',
            'SODIUM' => 'nullable|numeric|between:0,9999.99',
            'SILICON' => 'nullable|numeric|between:0,9999.99',
            'IRON' => 'nullable|numeric|between:0,9999.99',
            'FE_CODE' => 'nullable|string|max:50',
            'LEAD' => 'nullable|string|max:50',
            'RECOMM1' => 'nullable|string|max:150',
            'Notes' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(array_map('strtoupper', $this->all()));
    }
}
