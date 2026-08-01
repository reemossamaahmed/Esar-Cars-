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
            ['name_en' => 'Toyota', 'name_ar' => 'تويوتا'],
            ['name_en' => 'Hyundai', 'name_ar' => 'هيونداي'],
            ['name_en' => 'Kia', 'name_ar' => 'كيا'],
            ['name_en' => 'Nissan', 'name_ar' => 'نيسان'],
            ['name_en' => 'Honda', 'name_ar' => 'هوندا'],
            ['name_en' => 'Mazda', 'name_ar' => 'مازدا'],
            ['name_en' => 'Ford', 'name_ar' => 'فورد'],
            ['name_en' => 'Chevrolet', 'name_ar' => 'شيفروليه'],
            ['name_en' => 'BMW', 'name_ar' => 'بي إم دبليو'],
            ['name_en' => 'Mercedes-Benz', 'name_ar' => 'مرسيدس بنز'],
            ['name_en' => 'Audi', 'name_ar' => 'أودي'],
            ['name_en' => 'Lexus', 'name_ar' => 'لكزس'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                [
                    'slug' => Str::slug($brand['name_en']),
                ],
                [
                    'name_en' => $brand['name_en'],
                    'name_ar' => $brand['name_ar'],
                    'logo_url' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
