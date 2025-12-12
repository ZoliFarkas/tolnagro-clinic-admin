<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsSeeder extends Seeder
{
    public function run()
    {
        Patient::factory()->count(20)->create();
    }
}
