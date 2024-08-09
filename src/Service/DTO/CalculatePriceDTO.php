<?php

declare(strict_types=1);

namespace App\Service\DTO;

readonly class CalculatePriceDTO
{
    private int $productId;
    private string $taxNumber;
    private string $coupon;

    public function __construct(array $data)
    {
        $this->productId = (int)$data['product'];
        $this->taxNumber = $data['taxNumber'];
        $this->coupon = $data['couponCode'] ?? '';
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCoupon(): string
    {
        return $this->coupon;
    }

}