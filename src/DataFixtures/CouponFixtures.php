<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Enum\CouponType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupons = [
            ['code' => 'P10', 'type' => CouponType::PERCENTAGE, 'value' => 10],
            ['code' => 'P15', 'type' => CouponType::PERCENTAGE, 'value' => 15],
            ['code' => 'F50', 'type' => CouponType::FIXED, 'value' => 50],
            ['code' => 'F25', 'type' => CouponType::FIXED, 'value' => 25],
        ];

        foreach ($coupons as $couponData) {
            $coupon = new Coupon();
            $coupon->setCode($couponData['code']);
            $coupon->setCouponType($couponData['type']);
            $coupon->setValue($couponData['value']);

            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
