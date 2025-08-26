<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Form;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Builders\PageBlocks;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    // public function show(Request $request, $slug){
    //     $pageData = $this->getPage($request, $slug);
    //     $page = $pageData['page'];
    //     $blocks = $pageData['blocks'];
    //     return view('frontend.pages.show', compact('page', 'blocks'));
    // }

    // public function preview(Request $request, $slug){
    //     $pageData = $this->getPage($request, $slug);
    //     $page = $pageData['page'];
    //     $blocks = $pageData['blocks'];
    //     $availableBlocks = PageBlocks::all();
    //     return view('frontend.pages.preview', compact('page', 'blocks','availableBlocks'));
    // }

    // private function getPage($request, $slug){
    //     $data['page'] = Page::where('slug', $slug)->firstOrFail();
    //     $builder = json_decode($data['page']->builder, true);
    //     $data['blocks'] = collect($builder ?? [])->map(function ($block) use ($slug) {
    //         if ($block['type'] === 'blogs') {
    //             $limit = $block['props']['limit']['value'] ?? 6;

    //             $block['props']['posts'] = Blog::latest()
    //                 ->take($limit)
    //                 ->get()
    //                 ->map(function ($blog) use ($slug) {
    //                     return [
    //                         'title' => $blog->title,
    //                         'excerpt' => Str::limit(strip_tags(Markdown::parse($blog->content ?? '')), 100),
    //                         'url' => route('frontend.blog.show', $blog->slug) . "?pageSlug=". $slug,
    //                         'published_at' => optional($blog->created_at)->format('M d, Y'),
    //                     ];
    //                 })
    //                 ->toArray();
    //         }

    //         if($block['type'] === 'form'){
    //             $block['props']['form'] = Form::with('formFields')->find($block['props']['form_id']);
    //         }
    //         return PageBlocks::make($block);
    //     })->filter();
    //     return $data;
    // }

    public function category(Request $request, $slug)
    {
        $search = $request->input('q');
        $limit = $request->input('limit') ?? 10;
        $view = $request->input('view') ?? 'grid';
        $selectedCategories = $request->input('categories');
        $sortBy = $request->input('sort_by');
        $clear = $request->input('clear') === 'true';
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $hasFilters = $selectedCategories || $sortBy || $priceMin || $priceMax;

        // Find the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Product::with([
                'category',
                'variants.attributeValues.attribute', 
            ])
            // Filter products by the current category
            ->where('category_id', $category->id)
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->when($selectedCategories, function ($query, $selectedCategories) {
                return $query->whereIn('category_id', $selectedCategories);
            })
            ->when($sortBy != '', function ($query) use ($sortBy) {
                [$column, $direction] = explode(',', $sortBy);
                return $query->orderBy($column, $direction);
            })
            ->when($priceMin != '' || $priceMax != '', function ($query) use ($priceMin, $priceMax) {
                if ($priceMin != '' && $priceMax != '') {
                    return $query->whereBetween('price', [$priceMin, $priceMax]);
                } elseif ($priceMin != '') {
                    return $query->where('price', '>=', $priceMin);
                } elseif ($priceMax != '') {
                    return $query->where('price', '<=', $priceMax);
                }
            });

        $products = $query->paginate($limit);

        if (!$clear && $hasFilters) {
            $products->appends($request->except('page'));
        }

        $products->appends(['view' => $view]);

        return view('frontend.categories.index', compact('products', 'category'));
    }

    public function blog($slug){
        $pageSlug = request()->get('pageSlug');
        $blog = Blog::toBase()->where('slug', $slug)->first();
        return view('frontend.pages.blog', compact('blog','pageSlug'));
    }
}
