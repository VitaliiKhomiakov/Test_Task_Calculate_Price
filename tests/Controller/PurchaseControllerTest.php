<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Enum\PaymentType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class PurchaseControllerTest extends WebTestCase
{
    public function testProcessPurchaseSuccess(): void
    {
        $client = static::createClient();
        $product = $this->getProduct();

        $data = [
            'product' => $product->getId(),
            'taxNumber' => 'FR123456789',
            'couponCode' => 'P10',
            'paymentProcessor' => PaymentType::PAYPAL->value,
        ];

        $client->request(Request::METHOD_POST, '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        self::assertResponseIsSuccessful();

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals('success', $responseContent['status']);
    }

    public function testProcessPurchaseValidationError(): void
    {
        $client = static::createClient();

        // no product id
        $data = [
            'taxNumber' => 'FR123456789',
            'paymentProcessor' => PaymentType::PAYPAL->value,
        ];

        $client->request(Request::METHOD_POST, '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        self::assertResponseStatusCodeSame(400);

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
    }

    public function testProcessPurchaseWithInvalidPaymentProcessor(): void
    {
        $client = static::createClient();

        // invalid paymentProcessor
        $data = [
            'product' => 1,
            'taxNumber' => 'FR123456789',
            'paymentProcessor' => 'INVALID_PROCESSOR',
        ];

        $client->request(Request::METHOD_POST, '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        self::assertResponseStatusCodeSame(400);

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        self::assertArrayHasKey('errors', $responseContent);
    }

    public function testProcessPurchaseWithMissingPaymentProcessor(): void
    {
        $client = static::createClient();

        // no paymentProcessor
        $data = [
            'product' => 1,
            'taxNumber' => 'FR123456789',
        ];

        $client->request(Request::METHOD_POST, '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        self::assertResponseStatusCodeSame(400);
        $responseContent = json_decode($client->getResponse()->getContent(), true);
        self::assertArrayHasKey('errors', $responseContent);
    }

    private function getProduct(): Product
    {
        $productRepository = static::getContainer()->get('doctrine')->getManager()->getRepository(Product::class);
        return $productRepository->findOneBy(['name' => 'iPhone']);
    }
}
