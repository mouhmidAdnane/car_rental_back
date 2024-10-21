<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    //run php artisan migrate:fresh before seeding

    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            AgencySeeder::class,
            VehiculeSeeder::class,
            VehiculePerAgencySeeder::class,
        ]);
    }
}
