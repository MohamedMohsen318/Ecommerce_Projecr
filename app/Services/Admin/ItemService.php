<?php

namespace App\Services\Admin;

use App\Enums\MediaType;
use App\Models\Item;

class ItemService
{
    public function getAll()
    {
        return Item::with(['categories.translations', 'media'])
            ->orderByDesc('id')
            ->get();
    }

    public function find(int $id): Item
    {
        return Item::findOrFail($id);
    }

    public function create(array $data): Item
    {
        $translation = $this->extractTranslation($data);
        $categoryIds = $this->extractCategoryIds($data);
        $image = $data['image'] ?? null;
        unset($data['image']);

        $item = Item::create($data);
        $item->setTranslation('en', ['en' => $translation]);
        $item->categories()->sync($categoryIds);

        if ($image) {
            $item->setMedia($image, MediaType::Image, 'items');
        }

        return $item;
    }

    public function update(Item $item, array $data): Item
    {
        $translation = $this->extractTranslation($data);
        $categoryIds = $this->extractCategoryIds($data);
        $image = $data['image'] ?? null;
        unset($data['image']);

        $item->update($data);
        $item->setTranslation('en', ['en' => $translation]);
        $item->categories()->sync($categoryIds);

        if ($image) {
            $item->setMedia($image, MediaType::Image, 'items');
        }

        return $item;
    }

    public function delete(Item $item): bool
    {
        return $item->delete();
    }

    private function extractTranslation(array &$data): array
    {
        $translation = [
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
        ];

        unset($data['name'], $data['description']);

        return $translation;
    }

    private function extractCategoryIds(array &$data): array
    {
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        return $categoryIds;
    }
}
