<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    use HasImageUpload;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate();

        return Inertia::render('Category/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'image' => 'required|image',
        ]);

        $category = Category::create($validated);

        if ($request->hasFile('image')) {
            $image = $this->saveImage($request->file('image'), 'categories', 400, 400);
            $category->update(['image' => $image]);
        }

        return redirect()->route(admin_route_name() . 'categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $category = Category::findOrFail($id);

        // return Inertia::render('Category/Show', [
        //     'category' => $category,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        
        return Inertia::render('Category/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'image' => 'nullable|image',
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            $this->deleteOldImage($category->getRawOriginal('image'), 'categories');

            $validated['image'] = $this->saveImage($request->file('image'), 'categories', 400, 400);
        }

        $category->update($validated);

        return redirect()->route(admin_route_name() . 'categories.index')
            ->with('success', 'Category updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $this->deleteOldImage($category->getRawOriginal('image'), 'categories');
        $category->delete();

        return redirect()->route(admin_route_name() . 'categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
