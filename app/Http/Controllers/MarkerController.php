<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $marker = Marker::create([
            'name' => $validated['title'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect()->back()->with('success', 'Marker added successfully!')->with('marker', $marker);;
    }
    // public function store(Request $request)
    // {
    //     //dd($request);
    // //     Marker::create($request->validate([
    // //         'title' => 'required|max:255',
    // //         'description' => 'required',
    // //     ]));
    // // }
        
        
    //     Marker::create([

    //         'name' => $request -> title,
    //         'description' => $request-> description,
    //         'latitude' => $request -> latitude,
    //         'longitude' => $request -> longitude,
    //     ]);
        
    //     return redirect()-> to(route('dashboard'));

    // }

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
        // Log::info('✏️ Update marker hit', [
        //     'marker_id' => $marker->id,
        //     'request_data' => $request->all(),
        // ]);
        // //dd($marker);
        // $marker->update([
        //     'name' => $request -> title,
        //     'description' => $request-> description,
        //     'latitude' => $request -> latitude,
        //     'longitude' => $request -> longitude,
        // ]);
        // // return redirect()->back();
        // return response()->noContent();

         // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Update the marker
        $marker->update($validated);

        // Return a 204 No Content response
        return redirect()->to(route('dashboard'))->with('marker', $marker);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marker $marker)
    {
        $marker->delete();
        return redirect()->back();
    }
}
