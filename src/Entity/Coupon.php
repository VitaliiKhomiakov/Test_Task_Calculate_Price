<?php

namespace App\Entity;

use App\Enum\CouponType;
use App\Repository\CouponRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name: 'coupon')]
#[ORM\UniqueConstraint(name: 'coupon_code_unique', columns: ['code'])]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $code;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $couponType;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $value;

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

    public function getCouponType(): CouponType
    {
        return CouponType::from($this->couponType);
    }

    public function setCouponType(CouponType $couponType): static
    {
        $this->couponType = $couponType->value;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;
        return $this;
    }
}
