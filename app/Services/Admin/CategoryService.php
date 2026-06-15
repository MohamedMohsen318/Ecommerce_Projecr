<?php

namespace App\Services\Admin;

use App\Enums\MediaType;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function getCategoriesForIndex()
    {
        return Category::with([
            'allChildren',
            'translations',
            'media',
        ])
            ->withCount('items')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function getCategoriesForSelect()
    {
        return Category::with([
            'translations',
            'allChildren.translations',
        ])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function getCategoriesForEdit(Category $category)
    {
        return Category::with([
            'translations',
            'allChildren.translations',
        ])
            ->where('id', '!=', $category->id)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function store(array $data): Category
    {
        $category = Category::create([
            'parent_id' => $data['parent_id'] ?? null,
            'slug'      => $this->makeUniqueSlug($data['translations']['en']['name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $data['translations']);

        if (isset($data['image'])) {
            $category->setMedia($data['image'], MediaType::Image, 'categories');
        }

        return $category;
    }

    public function update(array $data, Category $category): Category
    {
        $category->update([
            'parent_id' => $data['parent_id'] ?? null,
            'slug'      => $this->makeUniqueSlug(
                $data['translations']['en']['name'],
                $category->id
            ),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $data['translations']);

        if (isset($data['image'])) {
            $category->setMedia($data['image'], MediaType::Image, 'categories');
        }

        return $category->fresh();
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }

    private function syncTranslations(Category $category, array $translations): void
    {
        foreach ($translations as $locale => $content) {
            if (! empty($content['name'])) {
                $category->setTranslation($locale, $translations);
            }
        }
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug     = $baseSlug;
        $counter  = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
