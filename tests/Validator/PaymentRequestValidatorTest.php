<?php

namespace App\Tests\Validator;

use App\Enum\PaymentType;
use App\Exception\ValidationException;
use App\Validator\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentRequestValidatorTest extends TestCase
{
    private ValidatorInterface $validator;
    private PaymentRequestValidator $paymentRequestValidator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
        $this->paymentRequestValidator = new PaymentRequestValidator($this->validator);
    }

    public function testValidPaymentMethod(): void
    {
        $validPaymentMethod = PaymentType::PAYPAL->value;
        $this->paymentRequestValidator->validate($validPaymentMethod);
        $this->assertTrue(true);
    }

    public function testInvalidPaymentMethod(): void
    {
        $invalidPaymentMethod = 'INVALID_METHOD';
        $this->expectException(ValidationException::class);
        $this->paymentRequestValidator->validate($invalidPaymentMethod);
    }

    public function testEmptyPaymentMethod(): void
    {
        $emptyPaymentMethod = '';
        $this->expectException(ValidationException::class);
        $this->paymentRequestValidator->validate($emptyPaymentMethod);
    }
}
