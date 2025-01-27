<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;

class WheelBrakeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'unit_code' => Unit::inRandomOrder()->first()->code ?? 'DefaultUnitCode',
            'hm' => $this->faker->numberBetween(1000, 5000),
            'ed' => $this->faker->numberBetween(100, 500),
            'last_date' => $this->faker->date(),
            'flh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'flh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'frh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'frh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'rlh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'rlh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'rrh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'rrh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'picture' => $this->faker->imageUrl(640, 480, 'automobile', true, 'wheel-brake'),
            'resume_date' => $this->faker->optional()->date(),
            'remark' => $this->faker->optional()->sentence(),
            'resume_flh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'resume_flh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'resume_frh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'resume_frh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'resume_rlh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'resume_rlh_tbase' => $this->faker->randomFloat(2, 0, 10),
            'resume_rrh_rgauge' => $this->faker->randomFloat(2, 0, 10),
            'resume_rrh_tbase' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
