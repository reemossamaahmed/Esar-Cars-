<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CarMediaService
{
    public function store(Car $car, array $data): Car
    {

        return DB::transaction(function () use ($car, $data) {


            /*
            |--------------------------------------------------------------------------
            | Check Cover Images
            |--------------------------------------------------------------------------
            */

            $coverCount = collect($data['images'])
                ->where('is_cover', true)
                ->count();


            if ($coverCount !== 1) {

                throw ValidationException::withMessages([

                    'images' => [
                        __('car.exactly_one_cover_required')
                    ]

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Check Existing Cover
            |--------------------------------------------------------------------------
            */

            if (
                $car->images()
                    ->where('is_cover', true)
                    ->exists()
            ) {

                throw ValidationException::withMessages([

                    'images' => [
                        __('car.cover_already_exists')
                    ]

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Update Video
            |--------------------------------------------------------------------------
            */

            $car->update([

                'video_url' => $data['video_url'] ?? null

            ]);



            /*
            |--------------------------------------------------------------------------
            | Store Images
            |--------------------------------------------------------------------------
            */

            $orderIndex =
                ($car->images()->max('order_index') ?? 0) + 1;


            foreach ($data['images'] as $image) {


                $isCover = $image['is_cover'] ?? false;


                $car->images()->create([

                    'image_url' => $image['image_url'],

                    'is_cover' => $isCover,

                    'order_index' => $isCover
                        ? null
                        : $orderIndex++,

                ]);

            }


            return $car->load('images');

        });

    }
}
