<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Repository\Product;

use App\Domain\Model\Price\Currency;
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

    public function findPaginatedByFilters(array $filters, int $offset, int $limit): array
    {

        $qb = $this->createQueryBuilder('product');
        $qb->join('App\Domain\Model\Price\Price', 'price', 'WITH', 'price.sku = product.stockKeepingUnit.value');
        $qb->where('price.currency.value = :currency')
            ->setParameter('currency', $filters['currency'] ?? Currency::DEFAULT);

        if ($filters['category'] ?? null) {
            $qb->andWhere('product.category = :category')
                ->setParameter('category', $filters['category']);
        }
        if ($filters['priceLessThan'] ?? null) {
            $qb->andWhere('price.price <= :priceLessThan')
                ->setParameter('priceLessThan', $filters['priceLessThan']);
        }

        $qb->setFirstResult($offset * $limit)
            ->setMaxResults($limit);

        $qb->select('product');

        return $qb->getQuery()->getResult();
    }

}
