<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentType;
use App\Service\DTO\CalculatePriceDTO;
use App\Service\Payment\PaymentFactory;

readonly class PaymentService
{
    public function __construct(
        private PaymentFactory $paymentFactory,
        private PriceService $priceService
    )
    {
    }

    public function process(CalculatePriceDTO $calculatePriceDTO, PaymentType $paymentType): void
    {
        // need to add a lock for accidentally duplicated request!
        // the purchase should also be rolled back in an error case
        $totalPrice = $this->priceService->calculate($calculatePriceDTO);
        $paymentSystem = $this->paymentFactory->providePaymentProcessor($paymentType);
        $paymentSystem->processPayment($totalPrice);
    }
}