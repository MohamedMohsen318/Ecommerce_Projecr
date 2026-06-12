<?php

namespace App\Models\Relations;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CategoryRelationsTrait
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: Category::class,
            foreignKey: 'parent_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            related: Category::class,
            foreignKey: 'parent_id'
        );
    }

    public function allChildren(): HasMany
    {
        return $this->children()
            ->with([
                'allChildren' => function ($query) {
                    $query->withCount('items');
                }
            ])->withCount(relations: 'items');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Item::class,
            table: 'category_item'
        );
    }

}
