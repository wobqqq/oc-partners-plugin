<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Models;

final readonly class StoreModelDto
{
    public function __construct(
        public string  $address,
        public int     $partnerId,
        public int     $cityId,
        public int     $countryId,
        public ?string $externalId = null,
        public ?string $lat = null,
        public ?string $lon = null,
        public ?string $deletedAt = null,
    )
    {
    }
}
