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
            'category_id' => 1,
            'a/c' => true,
            'suitcases' => 2,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => true,
            'brand' => 'audi',
            'model' => 'A4',
            'fuel_type' => 'petrol',
        ]);
        
        Vehicule::create([
            'category_id' => 1,
            'a/c' => false,
            'suitcases' => 3,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => false,
            'brand' => 'bmw',
            'model' => 'X3',
            'fuel_type' => 'diesel',
        ]);
        
        Vehicule::create([
            'category_id' => 2,
            'a/c' => true,
            'suitcases' => 4,
            'doors' => 4,
            'passengers' => 7,
            'automatic' => true,
            'brand' => 'chevrolet',
            'model' => 'Suburban',
            'fuel_type' => 'gasoline',
        ]);
        
        Vehicule::create([
            'category_id' => 2,
            'a/c' => true,
            'suitcases' => 3,
            'doors' => 4,
            'passengers' => 6,
            'automatic' => false,
            'brand' => 'citroen',
            'model' => 'C3',
            'fuel_type' => 'petrol',
        ]);
        
        Vehicule::create([
            'category_id' => 1,
            'a/c' => true,
            'suitcases' => 2,
            'doors' => 2,
            'passengers' => 4,
            'automatic' => true,
            'brand' => 'fiat',
            'model' => '500',
            'fuel_type' => 'electric',
        ]);
        
        Vehicule::create([
            'category_id' => 2,
            'a/c' => true,
            'suitcases' => 4,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => true,
            'brand' => 'ford',
            'model' => 'Explorer',
            'fuel_type' => 'hybrid',
        ]);
        
        Vehicule::create([
            'category_id' => 1,
            'a/c' => true,
            'suitcases' => 3,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => false,
            'brand' => 'honda',
            'model' => 'Accord',
            'fuel_type' => 'petrol',
        ]);
        
        Vehicule::create([
            'category_id' => 1,
            'a/c' => true,
            'suitcases' => 2,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => true,
            'brand' => 'hyundai',
            'model' => 'Elantra',
            'fuel_type' => 'diesel',
        ]);
        
        Vehicule::create([
            'category_id' => 2,
            'a/c' => false,
            'suitcases' => 3,
            'doors' => 4,
            'passengers' => 7,
            'automatic' => true,
            'brand' => 'jaguar',
            'model' => 'F-Pace',
            'fuel_type' => 'gasoline',
        ]);
        
        Vehicule::create([
            'category_id' => 2,
            'a/c' => true,
            'suitcases' => 4,
            'doors' => 4,
            'passengers' => 5,
            'automatic' => true,
            'brand' => 'kia',
            'model' => 'Sorento',
            'fuel_type' => 'petrol',
        ]);
        
        

    }
}
