<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'video_url' => [
                'nullable',
                'url',
            ],


            'images' => [
                'required',
                'array',
                'min:1',
            ],


            'images.*.image_url' => [
                'required',
                'url',
            ],


            'images.*.is_cover' => [
                'sometimes',
                'boolean',
            ],

        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $images = $this->images ?? [];


            $covers = collect($images)
                ->where('is_cover', true)
                ->count();


            if ($covers !== 1) {

                $validator->errors()->add(
                    'images',
                    'Exactly one cover image is required.'
                );

            }

        });
    }
}
