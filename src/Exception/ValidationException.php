<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Exception;

class ValidationException extends Exception
{
    public function __construct(private readonly ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation failed');
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->violations as $violation) {
            $errors[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}
