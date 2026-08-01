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
                ['name_en' => 'Corolla',      'name_ar' => 'كورولا'],
                ['name_en' => 'Camry',        'name_ar' => 'كامري'],
                ['name_en' => 'Yaris',        'name_ar' => 'ياريس'],
                ['name_en' => 'Fortuner',     'name_ar' => 'فورتشنر'],
                ['name_en' => 'Land Cruiser', 'name_ar' => 'لاند كروزر'],
                ['name_en' => 'Hilux',        'name_ar' => 'هايلوكس'],
                ['name_en' => 'RAV4',         'name_ar' => 'راف 4'],
                ['name_en' => 'Prado',        'name_ar' => 'برادو'],
            ],

            'hyundai' => [
                ['name_en' => 'Accent',    'name_ar' => 'أكسنت'],
                ['name_en' => 'Elantra',   'name_ar' => 'إلنترا'],
                ['name_en' => 'Sonata',    'name_ar' => 'سوناتا'],
                ['name_en' => 'Tucson',    'name_ar' => 'توسان'],
                ['name_en' => 'Santa Fe',  'name_ar' => 'سانتا في'],
                ['name_en' => 'Creta',     'name_ar' => 'كريتا'],
            ],

            'kia' => [
                ['name_en' => 'Cerato',    'name_ar' => 'سيراتو'],
                ['name_en' => 'K5',        'name_ar' => 'كي 5'],
                ['name_en' => 'Sportage',  'name_ar' => 'سبورتاج'],
                ['name_en' => 'Sorento',   'name_ar' => 'سورينتو'],
                ['name_en' => 'Picanto',   'name_ar' => 'بيكانتو'],
            ],

            'nissan' => [
                ['name_en' => 'Sunny',     'name_ar' => 'صني'],
                ['name_en' => 'Altima',    'name_ar' => 'ألتيما'],
                ['name_en' => 'Patrol',    'name_ar' => 'باترول'],
                ['name_en' => 'X-Trail',   'name_ar' => 'إكس تريل'],
            ],

            'honda' => [
                ['name_en' => 'Civic',     'name_ar' => 'سيفيك'],
                ['name_en' => 'Accord',    'name_ar' => 'أكورد'],
                ['name_en' => 'CR-V',      'name_ar' => 'سي آر-في'],
            ],

            'mazda' => [
                ['name_en' => 'Mazda 3',   'name_ar' => 'مازدا 3'],
                ['name_en' => 'Mazda 6',   'name_ar' => 'مازدا 6'],
                ['name_en' => 'CX-5',      'name_ar' => 'سي إكس-5'],
            ],

            'ford' => [
                ['name_en' => 'Fusion',    'name_ar' => 'فيوجن'],
                ['name_en' => 'Explorer',  'name_ar' => 'إكسبلورر'],
                ['name_en' => 'Edge',      'name_ar' => 'إيدج'],
                ['name_en' => 'F-150',     'name_ar' => 'إف-150'],
            ],

            'chevrolet' => [
                ['name_en' => 'Spark',     'name_ar' => 'سبارك'],
                ['name_en' => 'Malibu',    'name_ar' => 'ماليبو'],
                ['name_en' => 'Tahoe',     'name_ar' => 'تاهو'],
                ['name_en' => 'Captiva',   'name_ar' => 'كابتيفا'],
            ],

            'bmw' => [
                ['name_en' => '320i',      'name_ar' => '320i'],
                ['name_en' => '520i',      'name_ar' => '520i'],
                ['name_en' => 'X3',        'name_ar' => 'X3'],
                ['name_en' => 'X5',        'name_ar' => 'X5'],
                ['name_en' => 'X7',        'name_ar' => 'X7'],
            ],

            'mercedes-benz' => [
                ['name_en' => 'C-Class',   'name_ar' => 'الفئة C'],
                ['name_en' => 'E-Class',   'name_ar' => 'الفئة E'],
                ['name_en' => 'S-Class',   'name_ar' => 'الفئة S'],
                ['name_en' => 'GLC',       'name_ar' => 'GLC'],
                ['name_en' => 'GLE',       'name_ar' => 'GLE'],
            ],

            'audi' => [
                ['name_en' => 'A3',        'name_ar' => 'A3'],
                ['name_en' => 'A4',        'name_ar' => 'A4'],
                ['name_en' => 'A6',        'name_ar' => 'A6'],
                ['name_en' => 'Q5',        'name_ar' => 'Q5'],
                ['name_en' => 'Q7',        'name_ar' => 'Q7'],
            ],

            'lexus' => [
                ['name_en' => 'ES',        'name_ar' => 'ES'],
                ['name_en' => 'IS',        'name_ar' => 'IS'],
                ['name_en' => 'RX',        'name_ar' => 'RX'],
                ['name_en' => 'LX',        'name_ar' => 'LX'],
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
                        'slug' => Str::slug($model['name_en']),
                    ],
                    [
                        'name_en' => $model['name_en'],
                        'name_ar' => $model['name_ar'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
