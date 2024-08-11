<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentType;
use App\Exception\PaymentException;
use App\Service\Payment\Interface\PaymentInterface;

readonly class PaymentFactory
{
    public function __construct(
        private PayPalService $payPalService,
        private StripeService $stripeService,
    ) {
    }

    public function providePaymentProcessor(PaymentType $paymentMethod): PaymentInterface
    {
        return match ($paymentMethod) {
            PaymentType::PAYPAL => $this->payPalService,
            PaymentType::STRIPE => $this->stripeService,
            default => throw new PaymentException('Unknown payment method: ' . $paymentMethod->value),
        };
    }
}