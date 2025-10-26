<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Ingredient;
use App\Models\Backend\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::orderBy('created_at', 'asc')->paginate(10);

        return Inertia::render('Ingredient/Index', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes = Recipe::latest()->pluck('title', 'id', 'created_at');

        return Inertia::render('Ingredient/Create', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'quantity' => 'required|string|max:50',
            'unit' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:255',
            'recipe_id' => 'required|string',
        ]);

        $ingredient = Ingredient::create($validated);
        
        return redirect()->route(admin_route_name() . 'ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $ingredient = Ingredient::findOrFail($id);

        // return Inertia::render('Ingredient/Show', [
        //     'ingredient' => $ingredient,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $recipes = Recipe::latest()->pluck('title', 'id', 'created_at');
        
        return Inertia::render('Ingredient/Edit', [
            'ingredient' => $ingredient,
            'recipes' => $recipes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'quantity' => 'required|string|max:50',
            'unit' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:255',
            'recipe_id' => 'required|string',
        ]);

        $ingredient = Ingredient::findOrFail($id);

        $ingredient->update($validated);

        return redirect()->route(admin_route_name() . 'ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = Ingredient::with('recipe')->findOrFail($id);

        $ingredient->delete();

        return redirect()->route(admin_route_name() . 'ingredients.index')
            ->with('success', 'Ingredient deleted successfully.');
    }
}
