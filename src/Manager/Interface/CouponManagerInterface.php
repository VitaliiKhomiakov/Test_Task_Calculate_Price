<?php

declare(strict_types=1);

namespace App\Manager\Interface;

use App\Entity\Coupon;

interface CouponManagerInterface
{
    public function getCouponByCode(string $code): Coupon;
}
