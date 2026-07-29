<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [

            'Sedan',

            'SUV',

            'Small Car',

            'Pickup',

            'Bus',

            'Luxury',

            'Van',

            'Convertible',

        ];
        foreach ($types as $type) {

            CarType::updateOrCreate(

                [
                    'slug' => Str::slug($type),
                ],

                [
                    'name'      => $type,
                    'icon_url'  => null,
                    'is_active' => true,
                ]

            );

        }
    }
}
