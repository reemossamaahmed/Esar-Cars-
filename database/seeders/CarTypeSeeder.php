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
            ['name_en' => 'Sedan',        'name_ar' => 'سيدان'],
            ['name_en' => 'SUV',          'name_ar' => 'دفع رباعي'],
            ['name_en' => 'Small Car',    'name_ar' => 'سيارة صغيرة'],
            ['name_en' => 'Pickup',       'name_ar' => 'بيك أب'],
            ['name_en' => 'Bus',          'name_ar' => 'حافلة'],
            ['name_en' => 'Luxury',       'name_ar' => 'فاخرة'],
            ['name_en' => 'Van',          'name_ar' => 'فان'],
            ['name_en' => 'Convertible',  'name_ar' => 'مكشوفة'],
        ];

        foreach ($types as $type) {
            CarType::updateOrCreate(
                [
                    'slug' => Str::slug($type['name_en']),
                ],
                [
                    'name_en' => $type['name_en'],
                    'name_ar' => $type['name_ar'],
                    'icon_url' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
