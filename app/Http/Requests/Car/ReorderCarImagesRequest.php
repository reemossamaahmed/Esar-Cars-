<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class ReorderCarImagesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'images' => [
                'required',
                'array',
                'min:1',
            ],

            'images.*.id' => [
                'required',
                'integer',
                'exists:car_images,id',
            ],

            'images.*.order_index' => [
                'required',
                'integer',
                'min:1',
            ],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $images = collect($this->images);

            /*
            |--------------------------------------------------------------------------
            | Duplicate Image IDs
            |--------------------------------------------------------------------------
            */

            if ($images->pluck('id')->duplicates()->isNotEmpty()) {

                $validator->errors()->add(
                    'images',
                    __('car.duplicate_image_ids')
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Duplicate Order Indexes
            |--------------------------------------------------------------------------
            */

            if ($images->pluck('order_index')->duplicates()->isNotEmpty()) {

                $validator->errors()->add(
                    'images',
                    __('car.duplicate_order_indexes')
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Stop if basic validation already failed
            |--------------------------------------------------------------------------
            */

            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $car = $this->route('car');

            /*
            |--------------------------------------------------------------------------
            | Check Images
            |--------------------------------------------------------------------------
            */

            foreach ($this->images as $image) {

                $carImage = $car
                    ->images()
                    ->where('id', $image['id'])
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | Image belongs to car
                |--------------------------------------------------------------------------
                */

                if (!$carImage) {

                    $validator->errors()->add(
                        'images',
                        __('car.image_not_belongs_to_car')
                    );

                    break;
                }

                /*
                |--------------------------------------------------------------------------
                | Cover image cannot be reordered
                |--------------------------------------------------------------------------
                */

                if ($carImage->is_cover) {

                    $validator->errors()->add(
                        'images',
                        __('car.cover_image_reorder_not_allowed')
                    );

                    break;
                }
            }

        });
    }
}
