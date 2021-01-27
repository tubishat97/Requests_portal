<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlightCollection;
use App\Models\Flight;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FlightController extends Controller
{

    use ApiResponser;

    public function search(Request $request)
    {
        $searchQuery = Flight::query();

        if ($request->has('flight_number')) {
            $searchQuery->where('flight_number', $request->flight_number);
        }

        $flights = $searchQuery->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new FlightCollection($flights));
    }
}
