<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarCalendarRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\CarCalendarService;

class CarCalendarController extends Controller
{
    public function __construct(private readonly CarCalendarService $calendarService)
    {
    }

    public function index(CarCalendarRequest $request, Car $car)
    {
        $this->authorize('view', $car);
        
        $calendar = $this->calendarService->getCalendar(
            $car,
            $request->validated()
        );

        return ApiResponse::success(
            $calendar,
            __('car.calendar_loaded')
        );
    }
}
