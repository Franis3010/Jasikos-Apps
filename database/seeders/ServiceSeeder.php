<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = require database_path('seeders/data/services.php');

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}