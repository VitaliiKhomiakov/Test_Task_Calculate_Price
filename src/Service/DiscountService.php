<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Enum\CouponType;

class DiscountService
{
    public function applyCoupon(float $productPrice, Coupon $coupon): float
    {
        return match ($coupon->getCouponType()) {
            CouponType::FIXED => $this->applyFixedDiscount($productPrice, $coupon->getValue()),
            CouponType::PERCENTAGE => $this->applyPercentageDiscount($productPrice, $coupon->getValue()),
            default => $productPrice,
        };
    }

    private function applyFixedDiscount(float $productPrice, float $discount): float
    {
        return max(0, $productPrice - $discount);
    }

    private function applyPercentageDiscount(float $productPrice, float $percentage): float
    {
        return max(0, $productPrice - ($productPrice * $percentage / 100));
    }

    public function applyTaxRate(float $productPrice, float $taxRate = 0): float
    {
        if ($taxRate > 0) {
            return $productPrice + ($productPrice * $taxRate / 100);
        }

        return $productPrice;
    }
}