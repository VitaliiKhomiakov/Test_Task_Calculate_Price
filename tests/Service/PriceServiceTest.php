<?php

namespace App\Tests\Service;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Enum\CouponType;
use App\Manager\CountryManager;
use App\Manager\CouponManager;
use App\Manager\ProductManager;
use App\Service\DiscountService;
use App\Service\DTO\CalculatePriceDTO;
use App\Service\PriceService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriceServiceTest extends TestCase
{
    private $entityManager;
    private $productRepository;
    private $productManager;
    private $couponManager;
    private $countryManager;
    private $discountService;
    private $priceService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->productRepository = $this->createMock(EntityRepository::class);

        $this->entityManager
            ->method('getRepository')
            ->willReturn($this->productRepository);

        $this->couponManager = $this->createMock(CouponManager::class);
        $this->countryManager = $this->createMock(CountryManager::class);
        $this->discountService = $this->createMock(DiscountService::class);

        $this->productManager = $this->createMock(ProductManager::class);

        $this->priceService = new PriceService(
            $this->productManager,
            $this->couponManager,
            $this->countryManager,
            $this->discountService
        );
    }

    public function testCalculateWithCouponAndTax(): void
    {
        $product = new Product();
        $product->setPrice(100.0);

        $coupon = new Coupon();
        $coupon->setCouponType(CouponType::PERCENTAGE);
        $coupon->setValue(10);

        $tax = new Tax();
        $country = new Country();
        $country->setCode('DE')
            ->setName('Germany');

        $tax->setCountry($country);
        $tax->setRate(20);
        $country->setTax($tax);

        $this->productRepository
            ->method('find')
            ->willReturn($product);

        $this->couponManager
            ->method('getCouponByCode')
            ->willReturn($coupon);

        $this->countryManager
            ->method('getCountyByCode')
            ->willReturn($country);

        $this->discountService
            ->method('applyCoupon')
            ->willReturn(90.0);

        $this->discountService
            ->method('applyTaxRate')
            ->willReturn(108.0);

        $dto = new CalculatePriceDTO([
            'product' => 1,
            'taxNumber' => 'DE123456',
            'couponCode' => 'P10'
        ]);

        $result = $this->priceService->calculate($dto);
        $this->assertEquals(108.0, $result);
    }

    public function testCalculateWithInvalidProduct(): void
    {
        $this->productManager
            ->method('getProductById')
            ->willThrowException(new NotFoundHttpException());

        $dto = new CalculatePriceDTO([
            'product' => 999,
            'taxNumber' => 'IT123456'
        ]);

        $this->expectException(NotFoundHttpException::class);
        $this->priceService->calculate($dto);
    }

    public function testGetCountryCodeFromTaxNumber(): void
    {
        $result = $this->priceService->getCountryCodeFromTaxNumber('US123456');
        $this->assertEquals('US', $result);
    }
}
