<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = ['Budi', 'Anggi', 'Restu'];

        foreach ($services as $name) {
            Service::create([
                'name' => $name,
                'image' => 'services/' . strtolower($name) . '.png',
            ]);
        }
    }
}