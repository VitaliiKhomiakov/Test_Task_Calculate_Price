<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CalculatePriceRequestDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Product ID is required')]
        #[Assert\Type(type: 'integer', message: 'Product ID must be a number')]
        public int $product,

        #[Assert\NotBlank(message: 'Tax number is required')]
        #[Assert\Regex(
            pattern: '/^([A-Za-z]{2,})(\d{9,})$/',
            message: 'Invalid tax number format'
        )]
        public string $taxNumber,

        #[Assert\Type(type: 'string', message: 'Coupon code must be a string')]
        public ?string $couponCode = null,
    ) {
    }
}
