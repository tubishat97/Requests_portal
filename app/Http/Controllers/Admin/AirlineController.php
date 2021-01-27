<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airlines = Airline::all();
        return view('admin.airlines.list', compact('airlines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.airlines.add');
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
            'name' => 'required',
        ];

        $request->validate($validations);

        try {
            $airline = new Airline();
            $airline->name = $request->name;
            $airline->save();

            return redirect()->route('admin.airline.index')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Airline $airline
     * @return \Illuminate\Http\Response
     */
    public function show(Airline $airline)
    {
        return view('admin.airlines.show', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Airline $airline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Airline $airline)
    {
        $validations = [
            'name' => 'required',
        ];


        $request->validate($validations);

        try {
            $airline->name = $request->name;
            $airline->save();

            $airline->save();
            return redirect()->route('admin.airline.show', $airline->id)->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Airline $airline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect(route('admin.airline.index'))->with('success', __('system-messages.delete'));
    }
}
