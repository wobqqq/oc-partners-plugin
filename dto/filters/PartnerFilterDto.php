<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Filters;

final readonly class PartnerFilterDto
{
    public function __construct(
        public ?array  $cityIds = [],
        public ?array  $countryIds = [],
        public ?array  $categoryIds = [],
        public ?string $search = null,
        public bool    $isOnline = false,
        public bool    $isOffline = false,
        public int     $page = 1,
        public string  $sortBy = 'name',
        public string  $sortDirection = 'asc',
        public int     $perPage = 14,
    )
    {
    }
}
