<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\GetCarCalendarService;
use Illuminate\Http\Request;

class CarCalendarController extends Controller
{

    public function __construct(
        private GetCarCalendarService $calendarService
    ) {
    }



    public function index(
        Request $request,
        Car $car
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);



        /*
        |--------------------------------------------------------------------------
        | Get Calendar
        |--------------------------------------------------------------------------
        */

        $calendar = $this->calendarService->get(

            $car,

            $request->integer('month'),

            $request->integer('year')

        );



        return ApiResponse::success(
            $calendar
        );

    }
}
