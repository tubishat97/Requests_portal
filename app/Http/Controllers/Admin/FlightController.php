<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flights = Flight::all();
        return view('admin.flights.list', compact('flights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $airlines = Airline::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });

        $airports = Airport::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });

        $airplanes = Airplane::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });

        return view('admin.flights.add', compact('airlines', 'airports', 'airplanes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'from_airport' => 'required|exists:airports,id',
            'to_airport' => 'required|exists:airports,id',
            'airline' => 'required|exists:airlines,id',
            'airplane' => 'required|exists:airplanes,id',
        ];

        $request->validate($validations);

        try {
            $flight = new Flight();
            $flight->airline_id = $request->airline;
            $flight->to_airport_id = $request->from_airport;
            $flight->to_airport_id = $request->to_airport;
            $flight->airplane_id = $request->airplane;
            $flight->save();

            $flight->flight_number = 'JO' . $flight->id . date('ymd');
            $flight->save();

            return redirect()->route('admin.flight.index')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {

        $airlines = Airline::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });

        $airports = Airport::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });

        $airplanes = Airplane::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });


        return view('admin.flights.show', compact('flight', 'airlines', 'airports', 'airplanes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $validations = [
            'from_airport' => 'required|exists:airports,id',
            'to_airport' => 'required|exists:airports,id',
            'airline' => 'required|exists:airlines,id',
            'airplane' => 'required|exists:airplanes,id',
        ];

        $request->validate($validations);

        try {

            $flight->airline_id = $request->airline;
            $flight->to_airport_id = $request->from_airport;
            $flight->to_airport_id = $request->to_airport;
            $flight->airplane_id = $request->airplane;
            $flight->save();

            $flight->save();
            return redirect()->route('admin.flight.show', $flight->id)->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect(route('admin.flight.index'))->with('success', __('system-messages.delete'));
    }
}
