<?php

namespace App\Tests\Service;

use App\Entity\Coupon;
use App\Enum\CouponType;
use App\Service\DiscountService;
use PHPUnit\Framework\TestCase;

class DiscountServiceTest extends TestCase
{
    private DiscountService $discountService;

    protected function setUp(): void
    {
        $this->discountService = new DiscountService();
    }

    public function testApplyCouponWithFixedDiscount(): void
    {
        $productPrice = 100.0;

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getCouponType')
            ->willReturn(CouponType::FIXED);
        $coupon->method('getValue')
            ->willReturn(20.0);

        $result = $this->discountService->applyCoupon($productPrice, $coupon);
        $this->assertEquals(80.0, $result);
    }

    public function testApplyCouponWithPercentageDiscount(): void
    {
        $productPrice = 100.0;

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getCouponType')
            ->willReturn(CouponType::PERCENTAGE);
        $coupon->method('getValue')
            ->willReturn(10.0);

        $result = $this->discountService->applyCoupon($productPrice, $coupon);
        $this->assertEquals(90.0, $result);
    }

    public function testApplyTaxRate(): void
    {
        $productPrice = 100.0;
        $taxRate = 20.0;

        $result = $this->discountService->applyTaxRate($productPrice, $taxRate);
        $this->assertEquals(120.0, $result);
    }
}
