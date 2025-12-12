<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    public function definition()
    {
        $reasons = [
            'Általános vizsgálat',
            'Allergia',
            'Fertőzés',
            'Kontroll',
            'Labor eredmények megbeszélése',
            'Sürgősségi panasz',
            'Tanácsadás'
        ];

        return [
            'reason' => $this->faker->randomElement($reasons),
            'visit_date' => $this->faker->dateTimeBetween('-90 days', 'now'),
            'notes' => $this->faker->optional()->text(200),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
