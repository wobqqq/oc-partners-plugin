<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Filters;

final readonly class CityFilterDto
{
    public function __construct(
        public ?array $countryIds = [],
        public ?int   $partnerId = null,
        public string $sortBy = 'sort_order',
        public string $sortDirection = 'asc',
    )
    {
    }
}
