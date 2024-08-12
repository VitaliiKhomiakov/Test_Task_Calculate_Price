<?php

declare(strict_types=1);

namespace App\Service;

use App\Manager\CountryManager;
use App\Manager\CouponManager;
use App\Manager\ProductManager;
use App\Service\DTO\CalculatePriceDTO;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriceService
{
    public function __construct(
        private ProductManager $productManager,
        private CouponManager $couponManager,
        private CountryManager $countryManager,
        private DiscountService $discountService,
    ) {
    }

    public function calculate(CalculatePriceDTO $calculatePriceDTO): float
    {
        $product = $this->productManager->getProductById($calculatePriceDTO->getProductId());

        try {
            $country = $this->countryManager->getCountyByCode(
                $this->getCountryCodeFromTaxNumber($calculatePriceDTO->getTaxNumber())
            );
        } catch (NotFoundHttpException $e) {
            throw new InvalidArgumentException('Tax number is not supported');
        }

        $price = $product->getPrice();

        if ($couponNumber = $calculatePriceDTO->getCoupon()) {
            $coupon = $this->couponManager->getCouponByCode($couponNumber);
            $price = $this->discountService->applyCoupon($product->getPrice(), $coupon);
        }

        return $this->discountService->applyTaxRate($price, $country->getTax()?->getRate());
    }

    public function getCountryCodeFromTaxNumber(string $taxNumber): string
    {
        if (preg_match('/^([A-Za-z]{2,})(\d{9,})$/', $taxNumber, $matches)) {
            return mb_strtoupper($matches[1]);
        }

        throw new \InvalidArgumentException('Invalid tax number format');
    }

}