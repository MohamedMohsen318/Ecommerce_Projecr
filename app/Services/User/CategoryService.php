<?php

namespace App\Services\User;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getRootCategories(){
        return Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'media',
                'children.media',
            ])
            ->get();
    }
    public function findByPath(string $path): Category{
        $slugs = explode('/', $path);
        $slug = end($slugs);
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'media',
                'children.media',
            ])
            ->firstOrFail();
        return $category;
    }

    public function getCategoryProducts(Category $category): LengthAwarePaginator
    {
        return Item::query()
            ->with(['media', 'categories.translations'])
            ->whereHas('categories', function ($query) use ($category) {
                $query->whereIn('categories.id', $this->categoryAndDescendantIds($category));
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
    }

    private function categoryAndDescendantIds(Category $category): array
    {
        $ids = [$category->id];
        $children = Category::where('parent_id', $category->id)->get();

        foreach ($children as $child) {
            $ids = array_merge($ids, $this->categoryAndDescendantIds($child));
        }

        return $ids;
    }
}
