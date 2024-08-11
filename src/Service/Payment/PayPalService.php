<?php

namespace App\Service\Payment;

use App\Exception\PaymentException;
use App\Service\Payment\Interface\PaymentInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

readonly class PayPalService implements PaymentInterface
{
    public function __construct(private PaypalPaymentProcessor $paypalPaymentProcessor)
    {
    }

    public function processPayment(float $amount): void
    {
        try {
            $this->paypalPaymentProcessor->pay($amount);
        } catch (\Exception $exception) {
            throw new PaymentException($exception->getMessage());
        }
    }
}