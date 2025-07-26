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

}
