<?php

declare(strict_types=1);

namespace App\Enum\Trait;

trait EnumValuesTrait
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
