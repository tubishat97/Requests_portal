<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airplane;
use Illuminate\Http\Request;

class AirplaneController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airplanes = Airplane::all();
        return view('admin.airplanes.list', compact('airplanes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.airplanes.add');
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
            'max_seat' => 'required|numeric',
            'type' => 'required',
        ];

        $request->validate($validations);

        try {
            $airplane = new Airplane();
            $airplane->name = $request->name;
            $airplane->max_seat = $request->max_seat;
            $airplane->type = $request->type;
            $airplane->save();

            return redirect()->route('admin.airplane.index')->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Airplane $airplane
     * @return \Illuminate\Http\Response
     */
    public function show(Airplane $airplane)
    {
        return view('admin.airplanes.show', compact('airplane'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Airplane $airplane
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Airplane $airplane)
    {
        $validations = [
            'name' => 'required',
            'max_seat' => 'required|numeric',
            'type' => 'required',
        ];


        $request->validate($validations);

        try {
            $airplane->name = $request->name;
            $airplane->max_seat = $request->max_seat;
            $airplane->type = $request->type;
            $airplane->save();

            $airplane->save();
            return redirect()->route('admin.airplane.show', $airplane->id)->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Airplane $airplane
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airplane $airplane)
    {
        $airplane->delete();
        return redirect(route('admin.airplane.index'))->with('success', __('system-messages.delete'));
    }
}
