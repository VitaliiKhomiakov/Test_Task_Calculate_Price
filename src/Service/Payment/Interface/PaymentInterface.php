<?php

namespace App\Service\Payment\Interface;

interface PaymentInterface
{
    public function processPayment(float $amount): void;
}