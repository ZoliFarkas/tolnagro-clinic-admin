<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Visit;

class VisitsSeeder extends Seeder
{
    public function run()
    {
        // minden beteghez 1-6 vizit
        Patient::all()->each(function ($patient) {
            $visitsCount = rand(1, 6);
            Visit::factory()->count($visitsCount)->create([
                'patient_id' => $patient->id,
            ]);
        });
    }
}
