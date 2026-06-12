<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CategoryService
{
    public function getCategoriesForIndex()
    {
        return Category::with([
            'allChildren',
            'translations',
            'media'
        ])
            ->withCount('items')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function getCategoriesForSelect()
    {
        return Category::with('translations')->get();
    }

    public function getCategoriesForEdit(Category $category)
    {
        return Category::with('translations')
            ->where('id', '!=', $category->id)
            ->get();
    }

    public function store(array $data): RedirectResponse
    {
        $category = Category::create([
            'parent_id' => $data['parent_id'] ?? null,
            'slug' => $this->makeUniqueSlug($data['translations']['en']['name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $data['translations']);

        if (isset($data['image'])) {
            $category->setMedia($data['image'], 'image', 'categories');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(
        array $data,
        Category $category
    ): RedirectResponse {
        $category->update([
            'parent_id' => $data['parent_id'] ?? null,
            'slug' => $this->makeUniqueSlug(
                $data['translations']['en']['name'],
                $category->id
            ),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $data['translations']);

        if (isset($data['image'])) {
            $category->setMedia($data['image'], 'image', 'categories');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(
        Category $category
    ): RedirectResponse {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
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
        $slug = $baseSlug;
        $counter = 1;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
