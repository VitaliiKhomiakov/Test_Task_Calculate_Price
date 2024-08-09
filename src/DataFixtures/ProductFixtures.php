<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            [
                'name'  => 'iPhone',
                'price' => 100,
            ],
            [
                'name'  => 'Headphones',
                'price' => 20,
            ],
            [
                'name'  => 'Phone case',
                'price' => 100,
            ],
        ];

        foreach ($items as $item) {
            $product = new Product();
            $product->setName($item['name'])
                ->setPrice($item['price']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}