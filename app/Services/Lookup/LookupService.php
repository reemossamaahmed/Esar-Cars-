<?php

namespace App\Services\Lookup;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\Feature;
class LookupService
{
    public function brands()
    {
        return Brand::query()
            ->where('is_active', true)
            ->orderBy('name_en')
            ->get();
    }

     public function carModels()
    {
        return CarModel::query()
            ->where('is_active', true)
            ->orderBy('name_en')
            ->get();
    }

    public function carTypes()
    {
        return CarType::query()
            ->where('is_active', true)
            ->orderBy('name_en')
            ->get();
    }

    public function cities()
    {
        return City::query()
            ->where('is_active', true)
            ->orderBy('name_en')
            ->get();
    }

    public function features()
    {
        return Feature::query()
            ->where('is_active', true)
            ->orderBy('name_en')
            ->get();
    }
}
