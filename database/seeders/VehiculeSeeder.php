<?php

namespace Database\Seeders;

use App\Models\Vehicule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicule::create([
            'category_id' => 1, // Replace with a valid category_id
            'a/c' => true,
            'suitcases' => 2,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => true,
            'brand' => 'bmw', // Replace with valid CarBrands::$brands value
            'model' => 'Corolla',
            'fuel_type' => 'petrol',
        ]);

        Vehicule::create([
            'category_id' => 1, // Replace with a valid category_id
            'a/c' => false,
            'suitcases' => 1,
            'doors' => 2,
            'passengers' => 2,
            'automatic' => false,
            'brand' => 'bmw', // Replace with valid CarBrands::$brands value
            'model' => 'Civic',
            'fuel_type' => 'diesel',
        ]);

    }
}
