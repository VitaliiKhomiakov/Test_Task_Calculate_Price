<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ProductManager
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function getProductById(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product;
    }
}