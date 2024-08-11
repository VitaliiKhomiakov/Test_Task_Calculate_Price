<?php

namespace App\Validator;

use App\Enum\PaymentType;
use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class PaymentRequestValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(string $paymentMethod): void
    {
        $constraint = new Assert\Choice([
            'choices' => array_column(PaymentType::cases(), 'value'),
            'message' => 'Invalid payment method. Allowed values are: {{ choices }}',
        ]);

        $errors = $this->validator->validate($paymentMethod, $constraint);

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }
    }
}