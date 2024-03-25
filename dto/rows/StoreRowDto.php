<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Rows;

final readonly class StoreRowDto
{
    public function __construct(
        public string $externalId,
        public string $address,
        public string $lat,
        public string $lon,
        public string $partnerExternalId,
        public string $cityExternalId,
    )
    {
    }
}
