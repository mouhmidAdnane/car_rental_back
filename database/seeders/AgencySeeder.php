<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        Agency::create([
            'name' => 'Agency One',
            'url' => 'http://agencyone.com',
            'email' => 'contact@agencyone.com',
            'phone' => '123456789',
            'city' => 'City One',
        ]);

        Agency::create([
            'name' => 'Agency Two',
            'url' => 'http://agencytwo.com',
            'email' => 'contact@agencytwo.com',
            'phone' => '987654321',
            'city' => 'City Two',
        ]);
        Agency::create([
            'name' => 'Agency Three',
            'url' => 'http://agencythree.com',
            'email' => 'contact@agencythree.com',
            'phone' => '9452264321',
            'city' => 'City Three',
        ]);
        
    }
}
