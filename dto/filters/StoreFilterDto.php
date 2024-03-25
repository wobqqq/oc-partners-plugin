<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Filters;

use Blackseadigital\Partners\Enums\QueryListMode;

final readonly class StoreFilterDto
{
    public function __construct(
        public string  $mode = QueryListMode::PAGINATION->value,
        public ?int    $partnerId = null,
        public ?int    $cityId = null,
        public ?int    $countryId = null,
        public ?int    $categoryId = null,
        public ?string $search = null,
        public bool    $isOnline = false,
        public bool    $isOffline = false,
        public int     $page = 1,
        public string  $sortBy = 'address',
        public string  $sortDirection = 'asc',
        public int     $perPage = 16,
    )
    {
    }
}
