<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{User, Designer, Customer, Category, Design, DesignMedia};

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        // Users
        $admin = User::firstOrCreate(['email'=>'admin@jasikos.test'],[
            'name'=>'Admin Jasikos','password'=>Hash::make('password'),'role'=>'admin'
        ]);
        $desU = User::firstOrCreate(['email'=>'designer@jasikos.test'],[
            'name'=>'Designer Satu','password'=>Hash::make('password'),'role'=>'designer','whatsapp'=>'628111111111'
        ]);
        $cusU = User::firstOrCreate(['email'=>'customer@jasikos.test'],[
            'name'=>'Customer Satu','password'=>Hash::make('password'),'role'=>'customer','whatsapp'=>'628122222222'
        ]);

        // Profiles
        $designer = Designer::firstOrCreate(['user_id'=>$desU->id],[
            'display_name'=>'Designer Satu','bio'=>'Cosplay designer'
        ]);
        Customer::firstOrCreate(['user_id'=>$cusU->id],[
            'address'=>'Cimahi'
        ]);

        // Categories
        $cats = ['female','male','fullset','kids','armored','wig','accessories'];
        foreach ($cats as $c) {
            Category::firstOrCreate(['slug'=>$c], ['name'=>ucfirst($c)]);
        }

        // Designs + media
        for ($i=1; $i<=3; $i++) {
            $title = "Sample Design $i";
            $design = Design::firstOrCreate(['slug'=>Str::slug($title)],[
                'designer_id'=>$designer->id,
                'title'=>$title,
                'description'=>'Contoh deskripsi',
                'price'=>rand(150000,450000),
                'status'=>'published',
            ]);
            // attach kategori random
            $design->categories()->syncWithoutDetaching(
                Category::inRandomOrder()->take(2)->pluck('id')->all()
            );
            // media dummy
            DesignMedia::firstOrCreate([
                'design_id'=>$design->id,'path'=>'sample/'.$i.'.jpg'
            ], ['type'=>'image','sort_order'=>0]);
        }
    }
}
