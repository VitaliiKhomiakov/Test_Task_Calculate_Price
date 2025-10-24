<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumValuesTrait;

enum CouponType: int
{
    use EnumValuesTrait;

    case FIXED = 1;
    case PERCENTAGE = 2;
}