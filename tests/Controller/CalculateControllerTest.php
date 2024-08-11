<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CalculateControllerTest extends WebTestCase
{
    public function testCalculatePriceSuccess(): void
    {
        $client = static::createClient();
        $product = $this->getProduct();

        $data = [
            'product' => $product->getId(),
            'taxNumber' => 'FR123456',
            'couponCode' => 'P10',
        ];

        $client->request(Request::METHOD_POST, '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        self::assertResponseIsSuccessful();


        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('total', $responseContent);
    }

    public function testCalculatePriceValidationError(): void
    {
        $client = static::createClient();
        // no productId
        $data = [
            'taxNumber' => 'FR123456',
            'couponCode' => 'P10',
        ];

        $client->request(Request::METHOD_POST, '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        self::assertResponseStatusCodeSame(400);

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
    }

    public function testCalculatePriceWithInvalidTaxNumber(): void
    {
        $client = static::createClient();
        $product = $this->getProduct();

        $data = [
            'product' => $product->getId(),
            'taxNumber' => '123456',
            'couponCode' => 'P10',
        ];

        $client->request(Request::METHOD_POST, '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        self::assertResponseStatusCodeSame(400);

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
    }

    private function getProduct(): Product
    {
        $productRepository = static::getContainer()->get('doctrine')->getManager()->getRepository(Product::class);
        return $productRepository->findOneBy(['name' => 'iPhone']);
    }
}
