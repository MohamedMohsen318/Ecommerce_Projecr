<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\CartService;
use Illuminate\Http\RedirectResponse;

class CartClearController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function destroy(): RedirectResponse
    {
        $this->cartService->clearCart();

        return back()->with('success', 'Cart cleared successfully.');
    }
}
