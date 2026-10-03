<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingRequest;
use App\Http\Responses\ApiResponse;

class BookingController extends Controller
{
    /**
     *Create a new booking.
    */
    public function store(BookingRequest $request)
    {
        return ApiResponse::success(
            $request->validated(),
            __('booking.validation_success')
        );
    }
}
