<?php

namespace App\Models\Traits;

use App\Enums\CouponType;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait HasCoupons
{
    // User Methods
    public function hasUsedCoupon(Coupon $coupon): bool
    {
        return $this->couponUsages()->where('coupon_id', $coupon->id)->exists();
    }

    public function couponUsageCount(Coupon $coupon): int
    {
        return $this->couponUsages()->where('coupon_id', $coupon->id)->count();
    }

    public function hasReachedCouponLimit(Coupon $coupon): bool
    {
        if (! $coupon->max_uses_per_user) {
            return false;
        }

        return $this->couponUsageCount($coupon) >= $coupon->max_uses_per_user;
    }

    // Coupon Accessors
    public function getIsValidAttribute(): bool
    {
        if (! $this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;

        return true;
    }

    public function getIsPercentageAttribute(): bool
    {
        return $this->type === CouponType::Percentage;
    }

    public function getIsFixedAttribute(): bool
    {
        return $this->type === CouponType::Fixed;
    }

    // Coupon Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeValid(Builder $query): Builder
    {
        $now = now();
        return $query
            ->where('is_active', true)
            ->whereRaw('(starts_at IS NULL OR starts_at <= ?)', [$now])
            ->whereRaw('(expires_at IS NULL OR expires_at > ?)', [$now]);
    }

    // Coupon Business Logic
    public function calculateDiscount(float $amount): float
    {
        if ($amount < (float) $this->min_order_amount) {
            return 0.0;
        }

        $discount = $this->is_percentage
            ? $this->percentageDiscount($amount)
            : $this->fixedDiscount($amount);

        return round($discount, 2);
    }

    private function percentageDiscount(float $amount): float
    {
        $discount = $amount * ($this->value / 100);

        return $this->max_discount_amount
            ? min($discount, (float) $this->max_discount_amount)
            : $discount;
    }

    private function fixedDiscount(float $amount): float
    {
        return min((float) $this->value, $amount);
    }

    public function recordUsage(User $user, Order $order, float $discountAmount): void
    {
        CouponUsage::create([
            'user_id'         => $user->id,
            'coupon_id'       => $this->id,
            'order_id'        => $order->id,
            'discount_amount' => $discountAmount,
        ]);

        $this->increment('used_count');
    }

    public function usageCountForUser(int $userId): int
    {
        return $this->usages()->where('user_id', $userId)->count();
    }
}
