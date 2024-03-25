<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Filters;

final readonly class CityFilterDto
{
    public function __construct(
        public ?int   $countryId = null,
        public string $sortBy = 'name',
        public string $sortDirection = 'asc',
    )
    {
    }
}
