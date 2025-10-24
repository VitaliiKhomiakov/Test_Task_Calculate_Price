<?php

declare(strict_types=1);

namespace App\Service\Price;

use App\DTO\Request\CalculatePriceRequestDTO;
use App\Manager\CountryManager;
use App\Manager\CouponManager;
use App\Manager\ProductManager;
use App\Service\Price\DiscountService;
use App\Service\Utils\TaxNumberParser;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class PriceCalculationService
{
    public function __construct(
        private ProductManager $productManager,
        private CouponManager $couponManager,
        private CountryManager $countryManager,
        private DiscountService $discountService,
        private TaxNumberParser $taxNumberParser,
    ) {
    }

    public function calculate(CalculatePriceRequestDTO $request): float
    {
        $product = $this->productManager->getProductById($request->product);

        try {
            $country = $this->countryManager->getCountyByCode(
                $this->taxNumberParser->getCountryCodeFromTaxNumber($request->taxNumber)
            );
        } catch (NotFoundHttpException $e) {
            throw new InvalidArgumentException('Tax number is not supported');
        }

        $price = $product->getPrice();

        if ($couponNumber = $request->couponCode) {
            $coupon = $this->couponManager->getCouponByCode($couponNumber);
            $price = $this->discountService->applyCoupon($price, $coupon);
        }

        return $this->discountService->applyTaxRate($price, $country->getTax()?->getRate());
    }
}
