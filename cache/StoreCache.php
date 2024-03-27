<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Cache;

use BlackSeaDigital\Partners\Dto\Filters\StoreFilterDto;
use Blackseadigital\Partners\Queries\StoreQuery;
use Cache;

final class StoreCache extends BasicCache
{
    public function __construct(private readonly StoreQuery $storeQuery)
    {
    }

    public function getFilteredMap(StoreFilterDto $storeFilterDto): string
    {
        $key = $this->generateCacheKey(__METHOD__, $storeFilterDto,);

        return Cache::remember($key, self::TTL, fn() => $this->storeQuery->getFilteredMap($storeFilterDto));
    }
}
