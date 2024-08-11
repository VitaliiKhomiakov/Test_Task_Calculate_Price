<?php

namespace App\Service\Payment;

use App\Exception\PaymentException;
use App\Service\Payment\Interface\PaymentInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripeService implements PaymentInterface
{
    public function __construct(private StripePaymentProcessor $stripePaymentProcessor)
    {
    }

    public function processPayment(float $amount): void
    {
        try {
            if (!$this->stripePaymentProcessor->processPayment($amount)) {
                throw new PaymentException();
            }
        } catch (\Exception $exception) {
            throw new PaymentException($exception->getMessage());
        }
    }
}