<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $existingUnit = Unit::where('code_unit', $row['code_unit'])->first();

        if ($existingUnit) {
            // Update data jika code_unit sudah ada
            $existingUnit->update([
                'type' => $row['tipe_unit'],
                'unit' => $row['unit'],
                'serial_number' => $row['serial_number'],
            ]);
            return null; // Return null karena kita hanya memperbarui
        }

        return new Unit([
            'type' => $row['tipe_unit'],
            'unit' => $row['unit'],
            'code_unit' => $row['code_unit'],
            'serial_number' => $row['serial_number'],
        ]);
    }
}
