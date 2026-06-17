<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ApplyCouponRequest;
use App\Services\User\CartService;
use Illuminate\Http\RedirectResponse;

class CartCouponController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function store(ApplyCouponRequest $request): RedirectResponse
    {
        $result = $this->cartService->applyCoupon($request->code);

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function destroy(): RedirectResponse
    {
        $this->cartService->removeCoupon();

        return back()->with('success', 'Coupon removed successfully.');
    }
}
