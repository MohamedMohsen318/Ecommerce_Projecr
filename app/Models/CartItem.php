<?php
namespace App\Models;

class CartItem
{
    public function __construct(
        public int $product_id,
        public string $name,
        public float $price,
        public int $quantity
    ) {}

    public function subtotal(): float
    {
        return $this->price * $this->quantity;
    }
}
