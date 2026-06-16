<?php
namespace App\Models;

class Cart
{
    public array $items = [];
    public float $total = 0;

    public function addItem(array $data)
    {
        $this->items[] = new CartItem(
            $data['product_id'],
            $data['name'],
            $data['price'],
            $data['quantity']
        );
    }

    public function updateItem($id, $quantity)
    {
        foreach ($this->items as $item) {
            if ($item->product_id == $id) {
                $item->quantity = $quantity;
            }
        }
    }

    public function removeItem($id)
    {
        $this->items = array_filter($this->items, function ($item) use ($id) {
            return $item->product_id != $id;
        });
    }
}
