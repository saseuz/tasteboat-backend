<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Cuisine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuisines = Cuisine::orderBy('created_at', 'asc')->paginate(10);

        return Inertia::render('Cuisine/Index', [
            'cuisines' => $cuisines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cuisine/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250|unique:cuisines,name',
        ]);

        $cuisine = Cuisine::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        
        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'Cuisine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cuisine = Cuisine::findOrFail($id);

        return Inertia::render('Cuisine/Show', [
            'cuisine' => $cuisine,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cuisine = Cuisine::findOrFail($id);
        
        return Inertia::render('Cuisine/Edit', [
            'cuisine' => $cuisine
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:250|unique:roles,name,'.$id,
        ]);

        $cuisine = Cuisine::findOrFail($id);

        $cuisine->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'cuisine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuisine = Cuisine::findOrFail($id);

        $cuisine->delete();

        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'Cuisine deleted successfully.');
    }
}
