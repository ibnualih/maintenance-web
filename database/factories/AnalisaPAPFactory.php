<?php

namespace Database\Factories;

use App\Models\AnalisaPAP; // Pastikan ini sesuai dengan lokasi model
use Illuminate\Database\Eloquent\Factories\Factory;

class AnalisaPAPFactory extends Factory
{
    protected $model = AnalisaPAP::class;

    public function definition()
    {
        return [
            'grouploc' => $this->faker->word,
            'ADD_CODE' => $this->faker->word,
            'branch' => $this->faker->word,
            'Lab_No' => $this->faker->word,
            'SAMPL_DT1' => $this->faker->date('Y-m-d'),
            'unit_id' => $this->faker->numberBetween(1, 3), // ID unit yang valid
            'customer_id' => $this->faker->numberBetween(1, 10), // ID customer yang valid
            'name' => $this->faker->name,
            'ComponentID' => $this->faker->numberBetween(1, 10), // Ubah ini menjadi integer yang valid
            'MODEL' => $this->faker->word,
            'OIL_TYPE' => $this->faker->word,
            'HRS_KM_TOT' => $this->faker->randomFloat(0, 0, 100),
            'oil_change' => $this->faker->boolean, // Menghasilkan true/false
            'visc_40' => $this->faker->randomFloat(2, 0, 100),
            'TBN_CODE' => $this->faker->word,
            'CALCIUM' => $this->faker->randomFloat(2, 0, 100),
            'ZINC_CODE' => $this->faker->word,
            'WATER' => $this->faker->randomFloat(2, 0, 100),
            'SODIUM' => $this->faker->randomFloat(2, 0, 100),
            'SILICON' => $this->faker->randomFloat(2, 0, 100),
            'IRON' => $this->faker->randomFloat(2, 0, 100),
            'FE_CODE' => $this->faker->word,
            'LEAD' => $this->faker->randomFloat(2, 0, 100),
            'RECOMM1' => $this->faker->sentence(10), // Menghasilkan kalimat dengan maksimal 10 kata
            'Notes' => $this->faker->sentence(4), // 5 adalah jumlah kata
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
    
}