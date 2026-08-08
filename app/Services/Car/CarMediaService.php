<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarImage;
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

    public function update(Car $car, array $data): Car
    {

        return DB::transaction(function () use ($car, $data) {


            /*
            |--------------------------------------------------------------------------
            | Update Video
            |--------------------------------------------------------------------------
            */

            if (array_key_exists('video_url', $data)) {

                $car->update([

                    'video_url' => $data['video_url']

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Update Cover Image
            |--------------------------------------------------------------------------
            */

            if (isset($data['cover_image'])) {


                $coverImage = $car
                    ->images()
                    ->where('is_cover', true)
                    ->first();



                if (!$coverImage) {

                    throw ValidationException::withMessages([

                        'cover_image' => [
                            __('car.cover_not_found')
                        ]

                    ]);

                }



                $coverImage->update([

                    'image_url' =>
                        $data['cover_image']['image_url']

                ]);

            }



            return $car->load('images');

        });

    }

    public function delete(Car $car, CarImage $image): Car
    {
        return DB::transaction(function () use ($car, $image) {


            /*
            |--------------------------------------------------------------------------
            | Prevent deleting cover image
            |--------------------------------------------------------------------------
            */

            if ($image->is_cover) {


                throw ValidationException::withMessages([

                    'image' => [
                        __('car.cover_delete_not_allowed')
                    ]

                ]);

            }



            /*
            |--------------------------------------------------------------------------
            | Delete Image
            |--------------------------------------------------------------------------
            */

            $image->delete();



            /*
            |--------------------------------------------------------------------------
            | Reorder Images
            |--------------------------------------------------------------------------
            */

            $images = $car
                ->images()
                ->where('is_cover', false)
                ->orderBy('order_index')
                ->get();



            foreach ($images as $index => $item) {


                $item->update([

                    'order_index' => $index + 1

                ]);

            }



            return $car->load('images');

        });

    }

    public function reorder(Car $car, array $data): Car
    {
        return DB::transaction(function () use ($car, $data) {


            foreach ($data['images'] as $image) {


                $car->images()
                    ->where('id', $image['id'])
                    ->update([

                        'order_index' => $image['order_index']

                    ]);

            }


            return $car->load('images');

        });
    }
}
