<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [

            [
                'name_en' => 'Riyadh',
                'name_ar' => 'الرياض',
                'country' => 'Saudi Arabia',
            ],

            [
                'name_en' => 'Jeddah',
                'name_ar' => 'جدة',
                'country' => 'Saudi Arabia',
            ],

            [
                'name_en' => 'Dammam',
                'name_ar' => 'الدمام',
                'country' => 'Saudi Arabia',
            ],

            [
                'name_en' => 'Dubai',
                'name_ar' => 'دبي',
                'country' => 'United Arab Emirates',
            ],

        ];

        foreach ($cities as $city) {

            City::updateOrCreate(

                [

                    'name_en' => $city['name_en'],

                ],

                $city

            );

        }
    }
}
