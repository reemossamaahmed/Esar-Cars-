<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;
use Illuminate\Support\Str;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [

            'Bluetooth',

            'GPS',

            'Sunroof',

            'Cruise Control',

            'Alloy Wheels',

            'Child Seat',

            'Delivery Available',

            'No Deposit Required',

            'Full Insurance',

            'All Payment Methods',

        ];

        foreach ($features as $feature) {

            Feature::updateOrCreate(

                [
                    'slug' => Str::slug($feature),
                ],

                [
                    'name'      => $feature,
                    'icon_url'  => null,
                    'is_active' => true,
                ]

            );

        }

    }
}
