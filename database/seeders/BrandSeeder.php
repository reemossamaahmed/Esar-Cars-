<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [

            'Toyota',

            'Hyundai',

            'Kia',

            'Nissan',

            'Honda',

            'Mazda',

            'Ford',

            'Chevrolet',

            'BMW',

            'Mercedes-Benz',

            'Audi',

            'Lexus',

        ];

        foreach ($brands as $brand) {

            Brand::updateOrCreate(

                [
                    'slug' => Str::slug($brand),
                ],

                [
                    'name' => $brand,
                    'logo_url' => null,
                    'is_active' => true,
                ]

            );

        }
    }
}
