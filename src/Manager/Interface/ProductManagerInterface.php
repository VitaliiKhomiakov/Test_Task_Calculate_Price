<?php

declare(strict_types=1);

namespace App\Manager\Interface;

use App\Entity\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ProductManagerInterface
{
    public function getProductById(int $id): Product;
}
