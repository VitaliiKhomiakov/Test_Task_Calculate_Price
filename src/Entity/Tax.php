<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tax')]
#[ORM\Entity]
class Tax
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'tax')]
    #[ORM\JoinColumn(name: 'country_id', referencedColumnName: 'id')]
    private ?Country $country;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $rate;

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;
        return $this;
    }
}