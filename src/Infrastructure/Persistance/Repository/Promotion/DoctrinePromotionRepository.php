<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Repository\Promotion;

use App\Domain\Model\Promotion\Promotion;
use App\Domain\Model\Promotion\PromotionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrinePromotionRepository extends ServiceEntityRepository implements PromotionRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function save(Promotion $promotion): void
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->persist($promotion);
            $entityManager->flush();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('promotion');

        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $qb->andWhere($qb->expr()->in("promotion.$column", ":$column"))
                    ->setParameter($column, $value);
            } else {
                $qb->andWhere("promotion.$column = :$column")
                    ->setParameter($column, $value);
            }
        }

        return $qb->getQuery()->getResult();
    }
}
