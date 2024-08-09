<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CountryManager
{
    public function __construct(
        private CountryRepository $couponRepository,
    ) {
    }

    public function getCountyByCode(string $code): Country
    {
        $country = $this->couponRepository->findOneBy(['code' => $code]);
        if (!$country) {
            throw new NotFoundHttpException('Country not found');
        }

        return $country;
    }
}