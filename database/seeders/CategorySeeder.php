<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = ['female','male','fullset','kids','armored','wig','accessories'];
        foreach ($cats as $c) {
            Category::firstOrCreate(
                ['slug' => Str::slug($c)],
                ['name' => ucfirst($c)]
            );
        }
    }
}
