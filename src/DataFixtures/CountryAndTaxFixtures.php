<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryAndTaxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $countries = [
            ['code' => 'DE', 'name' => 'Germany', 'taxRate' => 19.00],
            ['code' => 'IT', 'name' => 'Italy', 'taxRate' => 22.00],
            ['code' => 'FR', 'name' => 'France', 'taxRate' => 20.00],
            ['code' => 'GR', 'name' => 'Greece', 'taxRate' => 24.00],
        ];

        foreach ($countries as $countryData) {
            $country = new Country();
            $country->setCode($countryData['code']);
            $country->setName($countryData['name']);

            $tax = new Tax();
            $tax->setRate($countryData['taxRate']);
            $tax->setCountry($country);

            $country->setTax($tax);

            $manager->persist($country);
            $manager->persist($tax);
        }

        $manager->flush();
    }
}
