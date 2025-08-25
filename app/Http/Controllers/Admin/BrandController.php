<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the brands.
     */
    public function index()
    {
        $searchQuery = request('q') ?? null;
        $limit = request('limit') ?? 10;
        $brands = Term::query()
                    ->filter($searchQuery,'brand')
                    ->where('type', 'brand')
                    ->latest()->paginate($limit)->withQueryString();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:terms,title',
        ]);

        Term::create([
            'type' => 'brand',
            'title' => $request->title,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit($id)
    {
        $brand = Term::where('type', 'brand')->findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = Term::where('type', 'brand')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:terms,title,' . $brand->id,
        ]);

        $brand->update([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy($id)
    {
        $brand = Term::where('type', 'brand')->findOrFail($id);
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
