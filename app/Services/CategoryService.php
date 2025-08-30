<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class CategoryService
{
    public function getPaginatedItems($params){
        $query = Category::withCount('products');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('title', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $categories = $query->orderBy('id', 'desc')->paginate($limit)->through(function($category) {
            $category->created_at = $category->created_at->diffForHumans();
            return $category;
        });
        $categories->appends($params);

        return $categories;
    }

    public function renderCategoriesSelect($skipId = null, $parentId = null)
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
}
