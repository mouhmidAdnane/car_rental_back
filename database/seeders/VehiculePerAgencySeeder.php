<?php

namespace Database\Seeders;

use App\Models\CarPerAgency;
use Illuminate\Database\Seeder;

class VehiculePerAgencySeeder extends Seeder
{
    public function run(): void
    {
        CarPerAgency::create([
            'agency_id' => 1, // Replace with a valid agency_id
            'vehicule_id' => 5, // Replace with a valid vehicule_id
            'stock' => 10,
            'available' => 8,
            'reserved' => 2,
            'picked_up' => 0,
            'price_per_day' => 50.00,
        ]);

        CarPerAgency::create([
            'agency_id' => 2, // Replace with a valid agency_id
            'vehicule_id' => 6, // Replace with a valid vehicule_id
            'stock' => 5,
            'available' => 3,
            'reserved' => 2,
            'picked_up' => 0,
            'price_per_day' => 40.00,
        ]);
    }
}
