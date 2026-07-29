<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            'toyota' => [
                'Corolla',
                'Camry',
                'Yaris',
                'Fortuner',
                'Land Cruiser',
                'Hilux',
                'RAV4',
                'Prado',
            ],

            'hyundai' => [
                'Accent',
                'Elantra',
                'Sonata',
                'Tucson',
                'Santa Fe',
                'Creta',
            ],

            'kia' => [
                'Cerato',
                'K5',
                'Sportage',
                'Sorento',
                'Picanto',
            ],

            'nissan' => [
                'Sunny',
                'Altima',
                'Patrol',
                'X-Trail',
            ],

            'honda' => [
                'Civic',
                'Accord',
                'CR-V',
            ],

            'mazda' => [
                'Mazda 3',
                'Mazda 6',
                'CX-5',
            ],

            'ford' => [
                'Fusion',
                'Explorer',
                'Edge',
                'F-150',
            ],

            'chevrolet' => [
                'Spark',
                'Malibu',
                'Tahoe',
                'Captiva',
            ],

            'bmw' => [
                '320i',
                '520i',
                'X3',
                'X5',
                'X7',
            ],

            'mercedes-benz' => [
                'C-Class',
                'E-Class',
                'S-Class',
                'GLC',
                'GLE',
            ],

            'audi' => [
                'A3',
                'A4',
                'A6',
                'Q5',
                'Q7',
            ],

            'lexus' => [
                'ES',
                'IS',
                'RX',
                'LX',
            ],

        ];

        foreach ($data as $brandSlug => $models) {

            $brand = Brand::where('slug', $brandSlug)->first();

            if (! $brand) {
                continue;
            }

            foreach ($models as $model) {

                CarModel::updateOrCreate(

                    [
                        'brand_id' => $brand->id,
                        'slug'     => Str::slug($model),
                    ],

                    [
                        'name'      => $model,
                        'is_active' => true,
                    ]

                );

            }
        }
    }
}
