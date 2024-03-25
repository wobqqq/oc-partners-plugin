<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Models;

final readonly class CountryModelDto
{
    public function __construct(
        public string  $name,
        public ?string $externalId = null,
        public ?string $deletedAt = null,
    )
    {
    }
}
