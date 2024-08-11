<?php

namespace App\Exception;

use Exception;

class PaymentException extends Exception
{
    public function __construct(string $message = 'Payment error')
    {
        parent::__construct($message);
    }
}