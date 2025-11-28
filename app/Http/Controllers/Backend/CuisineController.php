<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Cuisine;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuisineController extends Controller
{
    use HasImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuisines = Cuisine::orderBy('created_at', 'desc')->paginate();

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
        $validated = $request->validate([
            'name' => 'required|string|max:250|unique:cuisines,name',
            'description' => 'nullable|string',
            'image' => 'required|image'
        ]);

        $cuisine = Cuisine::create($validated);

        if ($request->hasFile('image')) {
            $image = $this->saveImage($request->file('image'), 'cuisines', 400, 400);
            $cuisine->update(['image' => $image]);
        }
        
        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'Cuisine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $cuisine = Cuisine::findOrFail($id);

        // return Inertia::render('Cuisine/Show', [
        //     'cuisine' => $cuisine,
        // ]);
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
        $validated = $request->validate([
            'name' => 'required|string|max:250|unique:roles,name,'.$id,
            'description' => 'nullable|string',
        ]);

        $cuisine = Cuisine::findOrFail($id);
        
        if ($request->hasFile('image')) {
            // Delete old image
            $this->deleteOldImage($cuisine->getRawOriginal('image'), 'cuisines');

            $validated['image'] = $this->saveImage($request->file('image'), 'cuisines', 400, 400);
        }

        $cuisine->update($validated);

        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'Cuisine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuisine = Cuisine::findOrFail($id);

        $this->deleteOldImage($cuisine->getRawOriginal('image'), 'cuisines');
        $cuisine->delete();

        return redirect()->route(admin_route_name() . 'cuisines.index')
            ->with('success', 'Cuisine deleted successfully.');
    }
}
