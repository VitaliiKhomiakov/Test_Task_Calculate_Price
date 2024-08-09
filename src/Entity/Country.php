<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'country')]
#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_country_code', columns: ['code'])]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToOne(mappedBy: 'country')]
    private ?Tax $tax = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): static
    {
        $this->tax = $tax;
        $tax?->setCountry($this);

        return $this;
    }
}