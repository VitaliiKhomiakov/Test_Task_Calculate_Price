<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumValuesTrait;

enum PaymentType: string
{
    use EnumValuesTrait;

    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
}