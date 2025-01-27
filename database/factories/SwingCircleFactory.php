<?php

namespace Database\Factories;

use App\Models\SwingCircle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SwingCircleFactory extends Factory
{
    protected $model = SwingCircle::class;

    public function definition()
    {
        return [
            'unit_model' => $this->faker->word,
            'unit_code' => $this->faker->unique()->bothify('UC-###'),
            'hm' => $this->faker->numberBetween(100, 10000),
            'ed' => $this->faker->numberBetween(100, 10000),
            'peak_value' => $this->faker->randomFloat(2, 0, 100),
            'front_value' => $this->faker->randomFloat(2, 0, 100),
            'front_picture' => 'images/dummy_front.jpg', // File gambar dummy di storage
            'rear_value' => $this->faker->randomFloat(2, 0, 100),
            'rear_picture' => 'images/dummy_rear.jpg', // File gambar dummy di storage
            'level_grease_picture' => 'images/dummy_level_grease.jpg', // File gambar dummy di storage
        ];
    }
}
