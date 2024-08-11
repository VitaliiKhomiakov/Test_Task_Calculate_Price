<?php

namespace App\Tests\Validator;

use App\Exception\ValidationException;
use App\Validator\CalculateRequestValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculateRequestValidatorTest extends TestCase
{
    private ValidatorInterface $validator;
    private CalculateRequestValidator $calculateRequestValidator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
        $this->calculateRequestValidator = new CalculateRequestValidator($this->validator);
    }

    public function testValidData(): void
    {
        $data = [
            'product' => 1,
            'taxNumber' => 'US123456',
            'couponCode' => 'SAVE20',
        ];

        $this->calculateRequestValidator->validate($data);
        $this->assertTrue(true);
    }

    public function testMissingProductField(): void
    {
        $data = [
            'taxNumber' => 'US123456',
        ];

        $this->expectException(ValidationException::class);
        $this->calculateRequestValidator->validate($data);
    }

    public function testInvalidProductField(): void
    {
        $data = [
            'product' => 'abc',
            'taxNumber' => 'US123456',
        ];

        $this->expectException(ValidationException::class);
        $this->calculateRequestValidator->validate($data);
    }

    public function testMissingTaxNumberField(): void
    {
        $data = [
            'product' => 1,
        ];

        $this->expectException(ValidationException::class);
        $this->calculateRequestValidator->validate($data);
    }

    public function testInvalidTaxNumberFormat(): void
    {
        $data = [
            'product' => 1,
            'taxNumber' => '123456US',
        ];

        $this->expectException(ValidationException::class);
        $this->calculateRequestValidator->validate($data);
    }

    public function testInvalidCouponCode(): void
    {
        $data = [
            'product' => 1,
            'taxNumber' => 'US123456',
            'couponCode' => 123,
        ];

        $this->expectException(ValidationException::class);
        $this->calculateRequestValidator->validate($data);
    }
}
