<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $limit = $request->input('limit') ?? 10;
        $view = $request->input('view') ?? 'grid'; 
        $selectedCategories = $request->input('categories');
        $sortBy = $request->input('sort_by');
        $clear = $request->input('clear') === 'true';
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $inStock = $request->input('in_stock');
        $hasFilters = $selectedCategories || $sortBy || $priceMin || $priceMax;

        $categories = Category::toBase()
                    ->whereNot('parent_id', 0)
                    ->orWhereNot('parent_id', null)
                    ->select('id','title','is_pc_part')->latest()->get();
        $query = Product::with([
                'category',
                'variants.attributeValues.attribute', 
            ])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->when($inStock == 'on', function ($query) {
                return $query->where(function ($q) {
                    $q->where('total_stocks', '>', 0)
                    ->orWhereHas('variants', function ($q2) {
                        $q2->where('total_stocks', '>', 0);
                    });
                });
            })
            ->when($selectedCategories, function ($query, $selectedCategories) {
                return $query->whereIn('category_id', $selectedCategories);
            })
            ->when($sortBy != '', function ($query) use ($sortBy) {
                [$column, $direction] = explode(',', $sortBy);
                return $query->orderBy($column, $direction);
            })->when($priceMin != '' || $priceMax != '', function ($query) use ($priceMin, $priceMax) {
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

        return view('frontend.products.index', compact('products','categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with([
            'category',
            'variants.attributeValues'
        ])->firstOrFail();
        $product->image =  $this->getImageUrl($product->image);

        $attributes = Attribute::whereHas('values.variants', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })->with(['values' => function($q) use ($product) {
            $q->whereHas('variants', function($q2) use ($product) {
                $q2->where('product_id', $product->id);
            });
        }])->get();

        // For the variant images
        $product->variants->transform(function ($v) {
            return [
                'id' => $v->id,
                'price' => $v->price,
                'sku' => $v->sku,
                'image' => $this->getImageUrl($v->image),
                'attribute_value_ids' => $v->attributeValues->pluck('id')->sort()->values()->all(),
            ];
        });

        return view('frontend.products.show', compact('product', 'attributes'));
    }

    public function pcBuilder(){
        $categories = Category::where('is_pc_part', true)->get();
        $products = Product::whereIn('category_id', $categories->pluck('id'))->get();
        return view('frontend.pc-builder.index', compact('categories','products'));
    }

    private function getImageUrl($image){
        return $image ? ((Str::startsWith($image, ['http://', 'https://']) ? $image : Storage::disk('public')->url($image))) : '';
    }
}
