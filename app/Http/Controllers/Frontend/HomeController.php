<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Term;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = $this->categories();
        $products = Product::where('type', 'simple')->orderBy('id', 'DESC')->limit(8)->get();
        $deals = Product::where('type', 'simple')->inRandomOrder()->orderBy('id', 'DESC')->limit(4)->get();
        $blogs = Blog::latest()->limit(4)->get();
        $slider = Term::where('type','top_slider')->with('sliderInfo')->first();
        $sliders = $slider->sliderInfo->value ? json_decode($slider->sliderInfo->value) : [];
        return view('welcome', compact('categories','products','deals','blogs','sliders'));
    }

    private function categories(){
        $categories = Category::whereHas('products')->whereNotNull('parent_id')
            ->select('id','title','slug')
            ->limit(6)
            ->get();

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


    // public function parseCategories()
    // {
    //     // Load all categories in a single query
    //     $categories = Category::orderBy('id')->get();

    //     // Build parent => children map
    //     $childrenMap = [];
    //     foreach ($categories as $cat) {
    //         $childrenMap[$cat->parent_id][] = $cat;
    //     }

    //     // Generate nested HTML
    //     $nestedHtml = $this->buildNestedHtml(null, $childrenMap);

    //     return view('frontend.categories', compact('nestedHtml'));
    // }

    // /**
    //  * Recursive HTML builder (pre-rendered)
    //  */
    // private function buildNestedHtml($parentId, $childrenMap)
    // {
    //     if (!isset($childrenMap[$parentId])) {
    //         return '';
    //     }

    //     $html = '<ul>';
    //     foreach ($childrenMap[$parentId] as $child) {
    //         $html .= '<li>' . $child->title;
    //         $html .= $this->buildNestedHtml($child->id, $childrenMap); // children
    //         $html .= '</li>';
    //     }
    //     $html .= '</ul>';

    //     return $html;
    // }
}
