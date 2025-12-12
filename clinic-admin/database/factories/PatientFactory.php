<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'birth_date' => $this->faker->optional(0.8)->date('Y-m-d', '-18 years'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
