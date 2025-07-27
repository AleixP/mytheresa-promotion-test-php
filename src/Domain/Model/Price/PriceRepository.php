<?php

declare(strict_types=1);

namespace App\Domain\Model\Price;

use App\Domain\Model\Product\StockKeepingUnit;

interface PriceRepository
{
    public function findBySku(StockKeepingUnit $productSku, Currency $currency): ?Price;
}
