<?php

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CalculateRequestValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'fields' => [
                'product' => new Assert\Required([
                    new Assert\NotBlank(['message' => 'Product ID is required']),
                    new Assert\Type([
                        'type'    => 'integer',
                        'message' => 'Product ID must be a number',
                    ]),
                ]),
                'taxNumber' => new Assert\Required([
                    new Assert\NotBlank(['message' => 'Tax number is required']),
                    new Assert\Regex([
                        'pattern' => '/^([A-Za-z]{2,})(\d{9,})$/',
                        'message' => 'Invalid tax number format',
                    ]),
                ]),
                'couponCode' => new Assert\Optional([
                    new Assert\Type([
                        'type'    => 'string',
                        'message' => 'Coupon code must be a string',
                    ]),
                ]),
                'paymentProcessor' => new Assert\Optional(),
            ],
        ]);

        $errors = $this->validator->validate($data, $constraints);

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }
    }
}
