<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airports = Airport::all();
        return view('admin.airports.list', compact('airports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = $this->lang;
        return view('admin.airports.add');
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
            'city_location' => 'required',
            'name' => 'required',
        ];

        $request->validate($validations);

        try {
            $airport = new Airport();
            $airport->city_location = $request->city_location;
            $airport->name = $request->name;
            $airport->lat = $request->lat;
            $airport->lon = $request->lon;
            $airport->save();

            return redirect()->route('admin.airport.index')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Airport $airport
     * @return \Illuminate\Http\Response
     */
    public function show(Airport $airport)
    {
        return view('admin.airports.show', compact('airport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Airport $airport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Airport $airport)
    {
        $validations = [
            'city_location' => 'required',
            'name' => 'required',
        ];


        $request->validate($validations);

        try {
            $airport->city_location = $request->city_location;
            $airport->name = $request->name;
            $airport->lat = $request->lat;
            $airport->lon = $request->lon;
            $airport->save();

            $airport->save();
            return redirect()->route('admin.airport.show', $airport->id)->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Airport $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airport $airport)
    {
        $airport->delete();
        return redirect(route('admin.airport.index'))->with('success', __('system-messages.delete'));
    }
}
