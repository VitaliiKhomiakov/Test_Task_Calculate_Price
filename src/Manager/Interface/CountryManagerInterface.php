<?php

declare(strict_types=1);

namespace App\Manager\Interface;

use App\Entity\Country;

interface CountryManagerInterface
{
    public function getCountyByCode(string $code): Country;
}
