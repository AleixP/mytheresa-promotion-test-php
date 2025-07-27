<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Repository\Price;

use App\Domain\Model\Price\Currency;
use App\Domain\Model\Price\Price;
use App\Domain\Model\Price\PriceRepository;
use App\Domain\Model\Product\StockKeepingUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrinePriceRepository extends ServiceEntityRepository implements PriceRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Price::class);
    }


    public function findBySku(StockKeepingUnit $productSku, Currency $currency): ?Price
    {
        $qb = $this->createQueryBuilder('price');
        $qb->where('price.sku = :sku')
            ->andWhere('price.currency.value = :currency')
            ->setParameter('sku', $productSku->value())
            ->setParameter('currency', $currency->value());

        return $qb->getQuery()->getOneOrNullResult();
    }

}
