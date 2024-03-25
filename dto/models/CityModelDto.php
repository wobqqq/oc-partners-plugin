<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Models;

final readonly class CityModelDto
{
    public function __construct(
        public string  $name,
        public int     $countryId,
        public ?string $externalId = null,
        public ?string $deletedAt = null,
    )
    {
    }
}
