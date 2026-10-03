<?php

namespace App\Http\Requests\Booking;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Car
            |--------------------------------------------------------------------------
            */
            'car_id' => [ 'required', 'uuid', 'exists:cars,id', ],
            /*
            |--------------------------------------------------------------------------
            | Pickup / Dropoff Cities
            |--------------------------------------------------------------------------
            */
            'pickup_city_id' => [ 'required', 'integer', 'exists:cities,id', ],
            'dropoff_city_id' => [ 'required', 'integer', 'exists:cities,id', ],
            /*
            |--------------------------------------------------------------------------
            | Booking Period
            |--------------------------------------------------------------------------
            */
            'pickup_at' => [ 'required', 'date', ],
            'dropoff_at' => [ 'required', 'date', 'after:pickup_at', ],
            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */
            'payment_method' => [ 'required', Rule::enum(PaymentMethod::class), ],
            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */
            'notes' => [ 'nullable', 'string', 'max:1000', ],
        ];
    }
}
