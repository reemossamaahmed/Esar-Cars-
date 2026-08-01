<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [

            ['name_en' => 'Bluetooth',          'name_ar' => 'بلوتوث'],
            ['name_en' => 'GPS Navigation',     'name_ar' => 'نظام ملاحة'],
            ['name_en' => 'Apple CarPlay',      'name_ar' => 'Apple CarPlay'],
            ['name_en' => 'Android Auto',       'name_ar' => 'Android Auto'],
            ['name_en' => 'USB Charger',        'name_ar' => 'منفذ USB'],
            ['name_en' => 'Wireless Charger',   'name_ar' => 'شاحن لاسلكي'],
            ['name_en' => 'Cruise Control',     'name_ar' => 'مثبت سرعة'],
            ['name_en' => 'Sunroof',            'name_ar' => 'فتحة سقف'],
            ['name_en' => 'Leather Seats',      'name_ar' => 'مقاعد جلد'],
            ['name_en' => 'Electric Seats',     'name_ar' => 'مقاعد كهربائية'],
            ['name_en' => 'Heated Seats',       'name_ar' => 'مقاعد مدفأة'],
            ['name_en' => 'Rear Camera',        'name_ar' => 'كاميرا خلفية'],
            ['name_en' => 'Parking Sensors',    'name_ar' => 'حساسات ركن'],
            ['name_en' => 'Air Conditioning',   'name_ar' => 'تكييف'],
            ['name_en' => 'ABS',                'name_ar' => 'نظام ABS'],
            ['name_en' => 'Airbags',            'name_ar' => 'وسائد هوائية'],
            ['name_en' => 'Child Seat',         'name_ar' => 'مقعد أطفال'],
            ['name_en' => 'Tinted Windows',     'name_ar' => 'زجاج مظلل'],
            ['name_en' => 'Alloy Wheels',       'name_ar' => 'جنوط ألمنيوم'],
            ['name_en' => 'Keyless Entry',      'name_ar' => 'دخول بدون مفتاح'],

        ];

        foreach ($features as $feature) {

            Feature::updateOrCreate(

                ['name_en' => $feature['name_en']],

                [
                    'name_ar'   => $feature['name_ar'],
                    'is_active' => true,
                ]

            );
        }
    }
}
