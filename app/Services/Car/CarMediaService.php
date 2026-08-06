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
            | Check Existing Images
            |--------------------------------------------------------------------------
            */

            $hasExistingImages = $car
                ->images()
                ->exists();



            /*
            |--------------------------------------------------------------------------
            | Count Cover Images In Request
            |--------------------------------------------------------------------------
            */

            $coverCount = collect($data['images'])
                ->where('is_cover', true)
                ->count();



            /*
            |--------------------------------------------------------------------------
            | First Time Media Upload
            |--------------------------------------------------------------------------
            |
            | لو العربية ليس لها صور:
            | لازم يكون فيه cover واحد
            |
            */

            if (
                !$hasExistingImages
                &&
                $coverCount !== 1
            ) {

                throw ValidationException::withMessages([

                    'images' => [
                        __('car.exactly_one_cover_required')
                    ]

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Prevent Adding Another Cover
            |--------------------------------------------------------------------------
            */

            if (
                $hasExistingImages
                &&
                $coverCount > 0
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

            if(
                array_key_exists(
                    'video_url',
                    $data
                )
            ){

                $car->update([

                    'video_url' => $data['video_url']

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Calculate Order Index
            |--------------------------------------------------------------------------
            */

            $orderIndex =
                ($car->images()->max('order_index') ?? 0) + 1;



            /*
            |--------------------------------------------------------------------------
            | Store Images
            |--------------------------------------------------------------------------
            */

            foreach($data['images'] as $image)
            {


                $isCover =
                    $image['is_cover'] ?? false;



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
