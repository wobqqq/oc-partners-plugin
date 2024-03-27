<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Filters;

use Blackseadigital\Partners\Queries\StoreQuery;

final readonly class StoreFilterDto
{
    public function __construct(
        public ?int    $partnerId = null,
        public ?array  $cityIds = [],
        public ?array  $countryIds = [],
        public ?array  $categoryIds = [],
        public ?string $search = null,
        public bool    $isOnline = false,
        public bool    $isOffline = false,
        public int     $page = 1,
        public int     $perPage = StoreQuery::LIST_PER_PAGE,
        public string  $sortBy = 'address',
        public string  $sortDirection = 'asc',
    )
    {
    }
}
