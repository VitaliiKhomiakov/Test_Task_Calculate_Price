<?php

declare(strict_types=1);

namespace App\Tests\Enum;

use App\Enum\CouponType;
use App\Enum\PaymentType;
use PHPUnit\Framework\TestCase;

class EnumValuesTraitTest extends TestCase
{

    public function testPaymentTypeGetValues(): void
    {
        $values = PaymentType::getValues();
        
        $this->assertContains('paypal', $values);
        $this->assertContains('stripe', $values);
        $this->assertCount(2, $values);
    }

    public function testCouponTypeGetValues(): void
    {
        $values = CouponType::getValues();
        
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertCount(2, $values);
    }
}
