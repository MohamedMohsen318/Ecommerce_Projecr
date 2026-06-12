<?php

namespace App\Models;

use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasTranslationsTrait;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasTranslationsTrait,
        HasMediaTrait;

    protected $table = 'items';

    protected $fillable = [
        'price',
        'discount_price',
        'is_active',
        'is_discount',
        'status',
        'stock',
        'sku'
    ];
}
