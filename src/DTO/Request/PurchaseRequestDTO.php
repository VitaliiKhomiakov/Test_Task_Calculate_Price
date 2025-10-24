<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Enum\PaymentType;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PurchaseRequestDTO
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

        #[Assert\NotBlank(message: 'Payment processor is required')]
        #[Assert\Choice(
            callback: [PaymentType::class, 'getValues'],
            message: 'Invalid payment method. Allowed values are: {{ choices }}'
        )]
        public string $paymentProcessor,

        #[Assert\Type(type: 'string', message: 'Coupon code must be a string')]
        public ?string $couponCode = null,
    ) {
    }

    public function getPaymentType(): PaymentType
    {
        return PaymentType::from($this->paymentProcessor);
    }
}
