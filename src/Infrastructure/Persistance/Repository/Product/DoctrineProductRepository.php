<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Repository\Product;

use App\Domain\Model\Price\Price;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function saveWithPrice(Product $product, Price $price): void
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->persist($product);
            $entityManager->persist($price);
            $entityManager->flush();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

}
