<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Repository\Price;

use App\Domain\Model\Price\Currency;
use App\Domain\Model\Price\Price;
use App\Domain\Model\Price\PriceRepository;
use App\Domain\Model\Product\StockKeepingUnit;
use Doctrine\ORM\EntityRepository;

final class DoctrinePriceRepository extends EntityRepository implements PriceRepository
{
    public function save(Price $price): void
    {
        // TODO: Implement save() method.
    }

    public function findBySku(StockKeepingUnit $productSku, Currency $currency): ?Price
    {
        // TODO: Implement findBySku() method.
    }

}
