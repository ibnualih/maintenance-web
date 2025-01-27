<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnalisaFuel>
 */
class AnalisaFuelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['normal', 'caution', 'critical']),  // Status dengan 3 opsi
            'lab_number' => 'LAB-' . $this->faker->unique()->numerify('#####'),          // Lab number yang unik
            'customer_name' => $this->faker->name(),                                     // Nama customer
            'branch' => $this->faker->randomElement(['Satui', 'Sampit', 'Batulicin']), // Nama cabang
            'sample_date' => $this->faker->date(),                                       // Tanggal sampel
            'report_date' => $this->faker->date(),                                       // Tanggal laporan
            'unit' => $this->faker->randomElement(['Excavator', 'Doozer', 'Heavy Dumptruck', 'Motor Grader']),  // Unit alat berat
            'type_unit' => $this->faker->randomElement(['Unit A', 'Unit B', 'Unit C']),  // Tipe unit
            'code_unit' => $this->faker->randomElement(['Code A', 'Code B', 'Code C']),  // Kode unit
            'serial_number' => $this->faker->unique()->numerify('SN-#####'),             // Serial number yang unik
        ];
    }
}
