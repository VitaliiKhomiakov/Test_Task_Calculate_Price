<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\Utils\TaxNumberParser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TaxNumberParserTest extends TestCase
{
    private TaxNumberParser $parser;

    protected function setUp(): void
    {
        $this->parser = new TaxNumberParser();
    }

    public function testGetCountryCodeFromValidTaxNumber(): void
    {
        $this->assertEquals('US', $this->parser->getCountryCodeFromTaxNumber('US123456789'));
        $this->assertEquals('DE', $this->parser->getCountryCodeFromTaxNumber('DE123456789'));
        $this->assertEquals('FR', $this->parser->getCountryCodeFromTaxNumber('FR123456789'));
        $this->assertEquals('IT', $this->parser->getCountryCodeFromTaxNumber('IT123456789'));
    }

    public function testGetCountryCodeFromInvalidTaxNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tax number format');
        
        $this->parser->getCountryCodeFromTaxNumber('123456789');
    }

    public function testGetCountryCodeFromShortTaxNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tax number format');
        
        $this->parser->getCountryCodeFromTaxNumber('US123');
    }

    public function testGetCountryCodeFromEmptyTaxNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tax number format');
        
        $this->parser->getCountryCodeFromTaxNumber('');
    }
}
