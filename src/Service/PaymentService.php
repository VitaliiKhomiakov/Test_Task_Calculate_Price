<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Request\CalculatePriceRequestDTO;
use App\DTO\Request\PurchaseRequestDTO;
use App\Service\Price\PriceCalculationService;
use App\Service\Payment\PaymentFactory;

readonly class PaymentService
{
    public function __construct(
        private PaymentFactory $paymentFactory,
        private PriceCalculationService $priceCalculationService
    )
    {
    }

    public function process(PurchaseRequestDTO $request): void
    {
        // need to add a lock for accidentally duplicated request!
        // the purchase should also be rolled back in an error case
        $calculateRequest = new CalculatePriceRequestDTO(
            product: $request->product,
            taxNumber: $request->taxNumber,
            couponCode: $request->couponCode
        );
        
        $totalPrice = $this->priceCalculationService->calculate($calculateRequest);
        $paymentSystem = $this->paymentFactory->providePaymentProcessor($request->getPaymentType());
        $paymentSystem->processPayment($totalPrice);
    }
}
