<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Coupon;
use App\Repository\CouponRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CouponManager
{
    public function __construct(
        private CouponRepository $couponRepository,
    ) {
    }

    public function getCouponByCode(string $code): Coupon
    {
        $coupon = $this->couponRepository->findOneBy(['code' => $code]);
        if (!$coupon) {
            throw new NotFoundHttpException('Coupon not found');
        }

        return $coupon;
    }
}