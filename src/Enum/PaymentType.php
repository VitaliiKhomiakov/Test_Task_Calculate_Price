<?php

namespace App\Enum;

enum PaymentType: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
}