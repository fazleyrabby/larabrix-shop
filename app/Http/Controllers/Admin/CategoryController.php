<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\CommonBusinessService;
use Illuminate\Http\Request;
use PDO;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryService $categoryService)
    {
        $categories = $categoryService->getPaginatedItems($request->all());
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::toBase()->pluck('title', 'id');
        // $categories = Category::toBase()->orderBy('id')->select('id','parent_id','title')->get();
        $categories = $this->renderCategoriesSelect();
        return view('admin.categories.create', compact('categories'));
    }

    private function renderCategoriesSelect($skipId = null, $parentId = null)
    {
        $query = Category::query();
        $categories = $query->orderBy('id')->get();
        $childrenMap = [];
        foreach ($categories as $cat) {
            $childrenMap[$cat->parent_id][] = $cat;
        }
        return $this->buildSelectOptions(null, $childrenMap, $skipId, $parentId);
    }

    private function buildSelectOptions($parentId, $childrenMap, $skipId = null, $selectedId = null, $prefix = '')
    {
        $html = '';
        if (!empty($childrenMap[$parentId])) {
            foreach ($childrenMap[$parentId] as $child) {
                // prefix spaces or dashes for indentation
                $attrs = ($skipId === $child->id) ? ' disabled' : '';
                $attrs .= ($selectedId === $child->id) ? ' selected' : '';
                $html .= sprintf(
                    '<option value="%d"%s>%s%s</option>',
                    $child->id,
                    $attrs,
                    $prefix,
                    e($child->title)
                );

                // recursive for children
                $html .= $this->buildSelectOptions($child->id, $childrenMap, $skipId, $selectedId, $prefix . ' &nbsp;&nbsp;&nbsp;');
            }
        }
        return $html;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191|unique:categories,title',
            'parent_id' => 'nullable',
            'slug' => 'required',
        ]);
        Category::create($validated);
        return redirect()->route('admin.products.categories.create')->with(['success' => 'Successfully created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // $this->authorize('create', Product::class);
        // $categories = Category::toBase()->whereNot('id', $category->id)->pluck('title', 'id');
        $categories = $this->renderCategoriesSelect($category->id, $category->parent_id);
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191|unique:categories,title,' . $id,
            'parent_id' => 'nullable',
            'slug' => 'required',
        ]);
        $category = Category::findOrFail($id);
        $category->update($validated);
        return redirect()->route('admin.products.categories.store')->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->back()
                ->with('error', 'This category already has some products!');
        }

        $category->delete();
        return redirect()->back()
            ->with('success', 'Category deleted successfully!');
    }
}
