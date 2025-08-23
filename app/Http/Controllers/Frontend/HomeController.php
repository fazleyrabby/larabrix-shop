<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = $this->categories();
        $products = Product::where('type', 'simple')->orderBy('id', 'DESC')->limit(8)->get();
        return view('welcome', compact('categories','products'));
    }

    private function categories(){
        $categories = Category::whereNull('parent_id')
            ->limit(6)
            ->pluck('title', 'id');

        // Check how many more we need
        $remaining = 6 - $categories->count();

        if ($remaining > 0) {
            // Get child categories to fill remaining slots
            $childCategories = Category::whereNotNull('parent_id')
                ->limit($remaining)
                ->pluck('title', 'id');

            // Merge parents and children
            $categories = $categories->union($childCategories);
        }
        return $categories;
    }
}
