<?php

namespace Database\Seeders;

use App\Models\CarPerAgency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VehiculePerAgencySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agency_vehicule')->insert([
            [
                'agency_id' => 1,
                'vehicule_id' => 1,
                'stock' => 5,
                'available' => 3,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 50.00,
            ],
            [
                'agency_id' => 1,
                'vehicule_id' => 2,
                'stock' => 4,
                'available' => 2,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 70.00,
            ],
            [
                'agency_id' => 1,
                'vehicule_id' => 3,
                'stock' => 3,
                'available' => 1,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 90.00,
            ],
            [
                'agency_id' => 2,
                'vehicule_id' => 4,
                'stock' => 6,
                'available' => 4,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 65.00,
            ],
            [
                'agency_id' => 2,
                'vehicule_id' => 5,
                'stock' => 2,
                'available' => 2,
                'reserved' => 0,
                'picked_up' => 0,
                'price_per_day' => 80.00,
            ],
            [
                'agency_id' => 2,
                'vehicule_id' => 6,
                'stock' => 5,
                'available' => 3,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 55.00,
            ],
            [
                'agency_id' => 3,
                'vehicule_id' => 7,
                'stock' => 4,
                'available' => 2,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 75.00,
            ],
            [
                'agency_id' => 3,
                'vehicule_id' => 8,
                'stock' => 3,
                'available' => 1,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 100.00,
            ],
            [
                'agency_id' => 3,
                'vehicule_id' => 9,
                'stock' => 2,
                'available' => 2,
                'reserved' => 0,
                'picked_up' => 0,
                'price_per_day' => 60.00,
            ],
            [
                'agency_id' => 3,
                'vehicule_id' => 10,
                'stock' => 5,
                'available' => 3,
                'reserved' => 1,
                'picked_up' => 1,
                'price_per_day' => 85.00,
            ],
        ]);
        
    }
}
