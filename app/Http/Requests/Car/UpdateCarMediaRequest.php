<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarMediaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [

            'video_url' => [
                'sometimes',
                'nullable',
                'url',
            ],


            'cover_image' => [
                'sometimes',
                'array',
            ],


            'cover_image.image_url' => [
                'required_with:cover_image',
                'url',
            ],


        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->all() === []) {

                $validator->errors()->add(
                    'update',
                    __('car.no_changes')
                );

            }

        });
    }

}
