<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Country;
use App\Manager\Interface\CountryManagerInterface;
use App\Repository\CountryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CountryManager implements CountryManagerInterface
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
