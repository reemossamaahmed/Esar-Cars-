<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class,]);
        $this->call([BrandSeeder::class,]);
        $this->call([CarTypeSeeder::class,]);
        $this->call([FeatureSeeder::class,]);
        $this->call([CarModelSeeder::class,]);
    }
}
