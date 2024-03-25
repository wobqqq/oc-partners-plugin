<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Rows;

final readonly class CityRowDto
{
    public function __construct(
        public string $name,
        public string $externalId,
        public string $countryExternalId,
    )
    {
    }
}
