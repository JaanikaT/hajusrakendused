<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //die("create marker");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
    //     Marker::create($request->validate([
    //         'title' => 'required|max:255',
    //         'description' => 'required',
    //     ]));
    // }
        
        
        Marker::create([

            'name' => $request -> title,
            'description' => $request-> description,
            'latitude' => $request -> latitude,
            'longitude' => $request -> longitude,
        ]);
        
        return redirect()-> to(route('dashboard'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Marker $marker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marker $marker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marker $marker)
    {
        //dd($marker);
        $marker->update([
            'name' => $request -> title,
            'description' => $request-> description,
            'latitude' => $request -> latitude,
            'longitude' => $request -> longitude,
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marker $marker)
    {
        //
    }
}
