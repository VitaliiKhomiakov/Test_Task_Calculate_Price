<?php

declare(strict_types=1);

namespace App\Service\Utils;

readonly class TaxNumberParser
{
    public function getCountryCodeFromTaxNumber(string $taxNumber): string
    {
        if (preg_match('/^([A-Za-z]{2,})(\d{9,})$/', $taxNumber, $matches)) {
            return mb_strtoupper($matches[1]);
        }

        throw new \InvalidArgumentException('Invalid tax number format');
    }
}
