<?php

namespace App\Imports;

use App\Models\Vhms;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class hd785Import implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $existingVHMS = VHMS::where('code', $row['code'])->first();

        if ($existingVHMS) {
            // Update data jika code sudah ada
            $existingVHMS->update([
                'sn' => $row['sn'],
                'hm' => (int)$row['hm'],
                'blowby_max' => (float)$row['blowby_max'],
                'boost_press_max' => (float)$row['boost_press_max'],
                'exh_temp_lf_max' => (float)$row['exh_temp_lf_max'],
                'exh_temp_lr_max' => (float)$row['exh_temp_lr_max'],
                'exh_temp_rf_max' => (float)$row['exh_temp_rf_max'],
                'exh_temp_rr_max' => (float)$row['exh_temp_rr_max'],
                'eng_oil_press_hmin' => (float)$row['eng_oil_press_hmin'],
                'eng_oil_press_lmin' => (float)$row['eng_oil_press_lmin'],
                'coolant_temp_max' => (float)$row['coolant_temp_max'],
                'eng_oil_temp_max' => (float)$row['eng_oil_temp_max'],
                'tm_oil_temp_max' => (float)$row['tm_oil_temp_max'],
            ]);
            return null; // Return null karena kita hanya memperbarui
        }

        return new VHMS([
            'code' => $row['code'],
            'sn' => $row['sn'],
            'hm' => (int)$row['hm'],
            'blowby_max' => (float)$row['blowby_max'],
            'boost_press_max' => (float)$row['boost_press_max'],
            'exh_temp_lf_max' => (float)$row['exh_temp_lf_max'],
            'exh_temp_lr_max' => (float)$row['exh_temp_lr_max'],
            'exh_temp_rf_max' => (float)$row['exh_temp_rf_max'],
            'exh_temp_rr_max' => (float)$row['exh_temp_rr_max'],
            'eng_oil_press_hmin' => (float)$row['eng_oil_press_hmin'],
            'eng_oil_press_lmin' => (float)$row['eng_oil_press_lmin'],
            'coolant_temp_max' => (float)$row['coolant_temp_max'],
            'eng_oil_temp_max' => (float)$row['eng_oil_temp_max'],
            'tm_oil_temp_max' => (float)$row['tm_oil_temp_max'],
        ]);
    }
}
